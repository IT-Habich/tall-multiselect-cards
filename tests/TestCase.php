<?php

namespace CodeAdminDe\TallMultiselectCards\Tests;

use CodeAdminDe\TallMultiselectCards\ServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
            LivewireServiceProvider::class,
        ];
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadLaravelMigrations();
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('tall-multiselect-cards.User.settings.paginate_data', false);
        $app['config']->set('tall-multiselect-cards.User.model', 'CodeAdminDe\TallMultiselectCards\Tests\Resources\Models\User');
        $app['config']->set('tall-multiselect-cards.StdClass.model', 'CodeAdminDe\TallMultiselectCards\Tests\Resources\StdClass');
    }
}
