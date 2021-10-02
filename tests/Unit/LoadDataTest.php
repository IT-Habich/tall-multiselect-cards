<?php

use CodeAdminDe\TallMultiselectCards\Http\Livewire\TallMultiselectCards;
use CodeAdminDe\TallMultiselectCards\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Orchestra\Testbench\Factories\UserFactory;

class LoadDataTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_shows_no_data_while_database_is_empty()
    {
        Livewire::test(TallMultiselectCards::class, ['identifier' => 'User'])
            ->assertSee("No records available.");
    }

    /** @test */
    function it_can_load_inital_data_from_database()
    {
        UserFactory::new()->count(1)->create(['name' => 'John Doe']);
        UserFactory::new()->count(2)->create();

        Livewire::test(TallMultiselectCards::class, ['identifier' => 'User'])
            ->assertSeeHtml('wire:click=\'toggleChecked("1")')
            ->assertSee('John Doe')
            ->assertSet('state.1.primary', 'John Doe')
            ->assertSet('state.1.checked', false)
            ->assertCount('state', 3);
    }

    /** @test */
    function it_uses_model_id_as_key_for_state_property()
    {
        $users = UserFactory::new()->count(5)->create();
        $users[3]->delete();
        $user = UserFactory::new()->create(['name' => 'John Doe']);
        UserFactory::new()->count(2)->create();

        $this->assertTrue($user->id === 6);

        Livewire::test(TallMultiselectCards::class, ['identifier' => 'User'])
            ->assertSeeHtml('wire:click=\'toggleChecked("1")')
            ->assertSee('John Doe')
            ->assertSet('state.6.primary', 'John Doe')
            ->assertSet('state.6.checked', false)
            ->assertCount('state', 7);
    }
}
