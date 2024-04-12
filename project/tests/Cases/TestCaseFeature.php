<?php

namespace Tests\Cases;

use App\Domains\Account\Models\Address;
use App\Domains\Account\Models\User;
use Database\Seeders\AddressStatesSeeder;
use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Event;
use Laravel\Sanctum\Sanctum;
use Tests\CreatesApplication;

abstract class TestCaseFeature extends BaseTestCase
{
    use CreatesApplication;
    use LazilyRefreshDatabase;

    protected ?string $currentController = null;

    protected function beforeRefreshingDatabase(): void
    {
        Event::listen(MigrationsEnded::class, function () {
            $this->artisan('db:seed', ['--class' => AddressStatesSeeder::class]);

            $this->app->make(\Spatie\Permission\PermissionRegistrar::class)
                ->forgetCachedPermissions();
        });
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Origin' => 'http://localhost',
        ]);
    }

    protected function useActionsFromController(string $controllerClass): static
    {
        $this->currentController = $controllerClass;

        return $this;
    }

    protected function controllerAction($action = null, $params = []): ?string
    {
        if (! $action) {
            return action($this->currentController, $params);
        }

        return action([$this->currentController, $action], $params);
    }

    protected function loginAsClient()
    {
        $user = User::factory()
            ->create();

        $this->actingAs($user);
        Sanctum::actingAs($user);
    }

    protected function createClientUserAddress(): void
    {
        $address = Address::factory()
            ->create();

        current_user()->address_id = $address->id;
        current_user()->save();
    }
}
