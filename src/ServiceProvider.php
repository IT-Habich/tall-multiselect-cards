<?php

namespace CodeAdminDe\TallMultiselectCards;

use CodeAdminDe\TallMultiselectCards\Http\Livewire\TallMultiselectCards;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Livewire\Livewire;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'tall-multiselect-cards');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'tall-multiselect-cards');

        Livewire::component('tall-multiselect-cards', TallMultiselectCards::class);

        $this->registerPublishables();
    }

    public function register(): void
    {
        //merge config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/tall-multiselect-cards.php',
            'tall-multiselect-cards'
        );
    }

    private function registerPublishables(): void
    {
        $this->publishes([
            __DIR__ . '/../config/tall-multiselect-cards.php' => config_path('tall-multiselect-cards.php'),
        ], 'tall-multiselect-cards-config');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/tall-multiselect-cards'),
        ], 'tall-multiselect-cards-views');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/tall-multiselect-cards'),
        ], 'tall-multiselect-cards-lang');
    }
}
