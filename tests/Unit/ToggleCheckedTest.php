<?php

use CodeAdminDe\TallMultiselectCards\Http\Livewire\TallMultiselectCards;
use CodeAdminDe\TallMultiselectCards\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Orchestra\Testbench\Factories\UserFactory;

class ToggleCheckedTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        UserFactory::new()->count(50)->create();
    }

    /** @test */
    function it_toggles_boolean_when_called_toggleChecked()
    {
        Livewire::test(TallMultiselectCards::class, ['identifier' => 'User'])
            ->assertSet('state.2.checked', false)
            ->assertSet('state.27.checked', false)
            ->assertSet('state.44.checked', false)
            ->assertDontSeeHtml('<svg class="check-circle')
            ->call('toggleChecked', 2)
            ->call('toggleChecked', 27)
            ->assertSet('state.2.checked', true)
            ->assertSet('state.27.checked', true)
            ->assertSet('state.44.checked', false)
            ->assertSeeHtml('<svg class="check-circle')
            ->call('toggleChecked', 2)
            ->call('toggleChecked', 27)
            ->assertSet('state.2.checked', false)
            ->assertSet('state.27.checked', false)
            ->assertSet('state.44.checked', false)
            ->assertDontSeeHtml('<svg class="check-circle');
    }
}
