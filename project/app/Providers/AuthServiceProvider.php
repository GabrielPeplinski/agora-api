<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Domains\Account\Models\Address;
use App\Domains\Account\Policies\AddressPolicy;
use App\Domains\Solicitation\Models\Solicitation;
use App\Domains\Solicitation\Policies\SolicitationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Address::class => AddressPolicy::class,
        Solicitation::class => SolicitationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
