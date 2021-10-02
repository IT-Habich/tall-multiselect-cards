<?php

use CodeAdminDe\TallMultiselectCards\Http\Livewire\TallMultiselectCards;
use CodeAdminDe\TallMultiselectCards\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Orchestra\Testbench\Factories\UserFactory;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        UserFactory::new()->count(20)->create();
        UserFactory::new()->count(1)->create(['name' => 'John Doe']);
        UserFactory::new()->count(2)->create();
    }

    /** @test */
    function it_hides_search_bar()
    {
        Livewire::test(TallMultiselectCards::class, ['identifier' => 'User'])
            ->assertSeeHtml('<input wire:model="searchTerm"')
            ->set('settings.hide_search', true)
            ->assertDontSeeHtml('<input wire:model="searchTerm"');
    }

    /** @test */
    function it_filters_data_by_search_string_when_called_search()
    {
        Livewire::test(TallMultiselectCards::class, ['identifier' => 'User'])
            ->assertSeeHtmlInOrder(['wire:click=\'toggleChecked("21")', 'John Doe'])
            ->set('searchTerm', 'something')
            ->assertDontSee('John Doe')
            ->set('searchTerm', 'John Doe')
            ->assertSeeHtmlInOrder(['wire:click=\'toggleChecked("21")', 'John Doe'])
            ->set('searchTerm', '')
            ->assertSeeHtmlInOrder(['wire:click=\'toggleChecked("21")', 'John Doe']);
    }

    /** @test */
    function it_filters_data_by_search_string_when_called_search_with_pagination()
    {
        $this->app['config']->set('tall-multiselect-cards.User.settings.paginate_data', true);
        $this->app['config']->set('tall-multiselect-cards.User.settings.paginate_data_per_page', 10);

        Livewire::test(TallMultiselectCards::class, ['identifier' => 'User'])
            ->assertDontSee('John Doe')
            ->set('searchTerm', 'something')
            ->assertDontSee('John Doe')
            ->set('searchTerm', 'John Doe')
            ->assertSeeHtmlInOrder(['wire:click=\'toggleChecked("21")', 'John Doe'])
            ->set('searchTerm', '')
            ->assertDontSee('John Doe');
    }

    /** @test */
    function it_filters_data_by_search_string_but_preserve_already_checked_cards()
    {
        Livewire::test(TallMultiselectCards::class, ['identifier' => 'User'])
            ->assertSeeHtmlInOrder(['wire:click=\'toggleChecked("21")', 'John Doe'])
            ->call('toggleChecked', 21)
            ->set('searchTerm', 'something')
            ->assertSeeHtmlInOrder(['wire:click=\'toggleChecked("21")', 'John Doe'])
            ->set('searchTerm', 'John Doe')
            ->assertSeeHtmlInOrder(['wire:click=\'toggleChecked("21")', 'John Doe'])
            ->set('searchTerm', '')
            ->assertSeeHtmlInOrder(['wire:click=\'toggleChecked("21")', 'John Doe'])
            ->call('toggleChecked', 21)
            ->set('searchTerm', 'something')
            ->assertDontSee('John Doe');
    }

    /** @test */
    function it_filters_data_by_search_string_but_preserve_already_checked_cards_with_pagination()
    {
        $this->app['config']->set('tall-multiselect-cards.User.settings.paginate_data', true);
        $this->app['config']->set('tall-multiselect-cards.User.settings.paginate_data_per_page', 10);

        Livewire::test(TallMultiselectCards::class, ['identifier' => 'User'])
            ->assertDontSee('John Doe')
            ->set('searchTerm', 'John Doe')
            ->assertSeeHtmlInOrder(['wire:click=\'toggleChecked("21")', 'John Doe'])
            ->call('toggleChecked', 21)
            ->set('searchTerm', 'something')
            ->assertSeeHtmlInOrder(['wire:click=\'toggleChecked("21")', 'John Doe'])
            ->set('searchTerm', '')
            ->assertSeeHtmlInOrder(['wire:click=\'toggleChecked("21")', 'John Doe'])
            ->call('toggleChecked', 21)
            ->set('searchTerm', 'something')
            ->assertDontSee('John Doe')
            ->set('searchTerm', '')
            ->assertDontSee('John Doe');
    }
}
