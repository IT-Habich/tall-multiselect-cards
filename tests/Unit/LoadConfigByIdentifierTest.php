<?php

use CodeAdminDe\TallMultiselectCards\Http\Livewire\TallMultiselectCards;
use CodeAdminDe\TallMultiselectCards\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Orchestra\Testbench\Factories\UserFactory;

class LoadConfigByIdentifierTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        UserFactory::new()->count(10)->create();
    }

    /** @test */
    function it_can_load_configuration_and_validate_model_when_valid_and_existing_identifier_is_used()
    {
        Livewire::test(TallMultiselectCards::class, ['identifier' => 'User'])
            ->assertSet('identifier', 'User')
            ->assertCount('settings', 25)
            ->assertCount('state', 10)
            ->assertCount('attributes', 4);
    }

    /** @test */
    function it_throws_IdentifierNotValidException_when_invalid_identifier_is_used()
    {
        $this->expectExceptionMessage('Identifier "Us!er" contains invalid chars. Only alpha_dash chars are allowed.');

        Livewire::test(TallMultiselectCards::class, ['identifier' => 'Us!er']);
    }

    /** @test */
    function it_throws_ConfigBySelectorNotFoundException_when_valid_and_non_existing_identifier_is_used()
    {
        $this->expectExceptionMessage('No configured identifier called "UserNotExisting" found.');

        Livewire::test(TallMultiselectCards::class, ['identifier' => 'UserNotExisting']);
    }

    /** @test */
    function it_throws_ModelNotFoundException_when_non_model_class_configured()
    {
        $this->expectExceptionMessage("Configuration item StdClass.model contains invalid class. Only subclasses of 'Illuminate\Database\Eloquent\Model' are allowed.");

        Livewire::test(TallMultiselectCards::class, ['identifier' => 'StdClass']);
    }
}
