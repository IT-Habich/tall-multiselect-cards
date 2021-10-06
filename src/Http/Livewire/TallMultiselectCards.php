<?php

namespace CodeAdminDe\TallMultiselectCards\Http\Livewire;

use CodeAdminDe\TallMultiselectCards\Exceptions\ConfigNotFoundException;
use CodeAdminDe\TallMultiselectCards\Exceptions\IdentifierNotValidException;
use CodeAdminDe\TallMultiselectCards\Exceptions\NoModelClassException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class TallMultiselectCards extends Component
{
    public $attributes;
    public $settings;
    public $model;
    public $identifier;
    public $page = 1;
    public $maxPages;
    public $state = [];
    public $searchTerm = '';


    public function mount(string $identifier): void
    {
        $this->validateIdentifierAndModel($identifier);

        $this->attributes = config('tall-multiselect-cards.' . $identifier . ".attributes");
        $this->settings = config('tall-multiselect-cards.' . $identifier . ".settings");
        $this->model = config('tall-multiselect-cards.' . $identifier . ".model");
        $this->identifier = $identifier;

        $this->state = $this->loadData();
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('tall-multiselect-cards::livewire.tall-multiselect-cards');
    }

    public function updatedSearchTerm($value): void
    {
        $this->page = 1;
        $this->state = collect($this->state)->where('checked', true)->toArray() + $this->loadData();
    }

    public function toggleChecked(string $id): void
    {
        $this->state[$id]['checked'] = !$this->state[$id]['checked'];
    }

    public function sendSelected(): void
    {
        $this->emit('tall-multiselect-cards-' . $this->identifier, collect($this->state)
            ->where('checked', true)
            ->keys()
            ->toArray());

        $this->clearSelected();
    }

    public function clearSelected(): void
    {
        collect($this->state)
            ->where('checked', true)
            ->each(function ($item, $key) {
                $this->state[$key]['checked'] = false;
            });
    }

    public function loadMoreData(): void
    {
        if ($this->page < $this->maxPages) {
            $this->page++;
            foreach ($this->loadData() as $key => $value) {
                $this->state[$key] = $value;
            }
        }
    }

    private function validateIdentifierAndModel(string $identifier): void
    {
        throw_if(Validator::make(['identifier' => $identifier], ['identifier' => 'alpha_dash'])->fails(), new IdentifierNotValidException("Identifier \"" . $identifier . "\" contains invalid chars. Only alpha_dash chars are allowed."));

        throw_if(empty(config('tall-multiselect-cards.' . $identifier)), new ConfigNotFoundException("No configured identifier called \"" . $identifier . "\" found."));

        throw_if(!is_subclass_of(config('tall-multiselect-cards.' . $identifier . ".model"), Model::class), new NoModelClassException("Configuration item " . $identifier . ".model contains invalid class. Only subclasses of 'Illuminate\Database\Eloquent\Model' are allowed."));
    }

    private function loadData(): array
    {
        $selectedAttributes = collect($this->attributes)->filter()->values()->toArray();

        if ($this::hasMacro('query')) {
            $query = $this::query($this->model, $selectedAttributes);
        } else {
            $query = $this->model::select($selectedAttributes);
        }

        $query->when('' !== $this->searchTerm, function ($q) use ($selectedAttributes) {
            foreach ($selectedAttributes as $key => $value) {
                if (0 === $key) {
                    $q->where($value, 'like', '%' . $this->searchTerm . '%');
                } else {
                    $q->orWhere($value, 'like', '%' . $this->searchTerm . '%');
                }
            }
        });

        if ($this->settings['paginate_data']) {
            $rows = $query->paginate($this->settings['paginate_data_per_page'], ['*'], 'page', $this->page);
            $this->maxPages = $rows->lastPage();
            $collection = $rows->getCollection();
        } else {
            $collection = $query->get();
            $this->maxPages = 0;
        }

        if ($this::hasMacro('filter')) {
            $collection = $this::filter($collection);
        }

        return $collection
            ->mapWithKeys(function ($item) {
                return in_array($item[$this->attributes['uniqueId']], collect($this->state)->where('checked', true)->keys()->toArray())
                    ? [NULL]
                    : [
                        $item[$this->attributes['uniqueId']] => [
                            'primary' => !empty($this->attributes['primary']) ? $item[$this->attributes['primary']] : NULL,
                            'secondary' => !empty($this->attributes['secondary']) ? $item[$this->attributes['secondary']] : NULL,
                            'optional' => !empty($this->attributes['optional']) ? $item[$this->attributes['optional']] : NULL,
                            'checked' => false,
                        ]
                    ];
            })->filter()->toArray();
    }
}
