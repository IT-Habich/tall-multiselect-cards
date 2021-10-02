<?php

use CodeAdminDe\TallMultiselectCards\Http\Livewire\TallMultiselectCards;
use CodeAdminDe\TallMultiselectCards\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Orchestra\Testbench\Factories\UserFactory;

class SelectTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        UserFactory::new()->count(50)->create();
    }

    /** @test */
    function it_shows_check_circle_icon_when_selected()
    {
        Livewire::test(TallMultiselectCards::class, ['identifier' => 'User'])
            ->assertDontSeeHtml('<svg class="check-circle');

        Livewire::test(TallMultiselectCards::class, ['identifier' => 'User'])
            ->set('state.2.checked', true)
            ->assertSeeHtml('<svg class="check-circle');
    }

    /** @test */
    function it_clears_selected_when_called_clearSelected()
    {
        Livewire::test(TallMultiselectCards::class, ['identifier' => 'User'])
            ->set('state.2.checked', true)
            ->set('state.30.checked', true)
            ->set('state.44.checked', true)
            ->assertSeeHtml('<svg class="check-circle')
            ->call('clearSelected')
            ->assertDontSeeHtml('<svg class="check-circle')
            ->assertSet('state.2.checked', false)
            ->assertSet('state.30.checked', false)
            ->assertSet('state.44.checked', false)
            ->assertSet('state.45.checked', false);
    }

    /** @test */
    function it_clears_selected_and_emits_event_when_called_sendSelected()
    {
        Livewire::test(TallMultiselectCards::class, ['identifier' => 'User'])
            ->set('state.3.checked', true)
            ->set('state.33.checked', true)
            ->set('state.47.checked', true)
            ->assertSeeHtml('<svg class="check-circle')
            ->call('sendSelected')
            ->assertEmitted('tall-multiselect-cards-User', [3, 33, 47])
            ->assertDontSeeHtml('<svg class="check-circle')
            ->assertSet('state.3.checked', false)
            ->assertSet('state.33.checked', false)
            ->assertSet('state.47.checked', false)
            ->assertSet('state.48.checked', false);
    }

    /** @test */
    function it_emits_event_with_empty_array_when_called_sendSelected()
    {
        Livewire::test(TallMultiselectCards::class, ['identifier' => 'User'])
            ->assertDontSeeHtml('<svg class="check-circle')
            ->call('sendSelected')
            ->assertEmitted('tall-multiselect-cards-User', [])
            ->assertDontSeeHtml('<svg class="check-circle');
    }
}
