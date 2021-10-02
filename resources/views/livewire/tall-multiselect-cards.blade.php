<div>
    @if (!$this->settings['hide_search'])
    <div class="mb-1 mx-1">
        <x-tall-multiselect-cards::search />
    </div>
    @endif
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
        @forelse ($this->state as $key => $item)
        <x-tall-multiselect-cards::card selected="{{ $item['checked'] }}" key="{{ $key }}" :item="$item" />
        @empty
        <span>{{ __('tall-multiselect-cards::strings.no_records') }}</span>
        @endforelse
    </div>
    @if ($this->page < $this->maxPages)
    <div class="w-full flex flex-row-reverse py-1 px-4 underline">
        <a wire:click.prevent="loadMoreData" href="#">{{ __('tall-multiselect-cards::strings.load_cards') }}</a>
    </div>
    @endif
    <div class="w-full flex flex-row-reverse py-1 px-3">
        <x-tall-multiselect-cards::button primary />
        <x-tall-multiselect-cards::button />
    </div>
</div>