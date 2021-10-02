<?php

use CodeAdminDe\TallMultiselectCards\Http\Livewire\TallMultiselectCards;
use CodeAdminDe\TallMultiselectCards\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Orchestra\Testbench\Factories\UserFactory;

class PaginateTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        UserFactory::new()->count(30)->create();
        $this->app['config']->set('tall-multiselect-cards.User.settings.paginate_data', true);
        $this->app['config']->set('tall-multiselect-cards.User.settings.paginate_data_per_page', 10);
    }

    /** @test */
    function it_paginates_content_above_pagination_limit_and_add_data_pagewise()
    {
        Livewire::test(TallMultiselectCards::class, ['identifier' => 'User'])
            ->assertSet('maxPages', 3)
            ->assertSet('page', 1)
            ->assertNotSet('state.1', NULL)
            ->assertNotSet('state.9', NULL)
            ->assertNotSet('state.10', NULL)
            ->assertSet('state.11', NULL)
            ->call('loadMoreData')
            ->assertSet('maxPages', 3)
            ->assertSet('page', 2)
            ->assertNotSet('state.1', NULL)
            ->assertNotSet('state.9', NULL)
            ->assertNotSet('state.10', NULL)
            ->assertNotSet('state.19', NULL)
            ->assertNotSet('state.20', NULL)
            ->assertSet('state.21', NULL)
            ->assertCount('state', 20)
            ->call('loadMoreData')
            ->assertSet('maxPages', 3)
            ->assertSet('page', 3)
            ->assertNotSet('state.1', NULL)
            ->assertNotSet('state.9', NULL)
            ->assertNotSet('state.10', NULL)
            ->assertNotSet('state.19', NULL)
            ->assertNotSet('state.20', NULL)
            ->assertNotSet('state.21', NULL)
            ->assertNotSet('state.29', NULL)
            ->assertNotSet('state.30', NULL)
            ->assertCount('state', 30)
            ->call('loadMoreData')
            ->assertCount('state', 30)
            ->assertSet('maxPages', 3)
            ->assertSet('page', 3);
    }
}
