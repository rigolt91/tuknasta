<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\UserContact' => 'App\Policies\UserContactPolicy',
        'App\Models\Branch' => 'App\Policies\UserRolePolicy',
        'App\Models\Category' => 'App\Policies\UserRolePolicy',
        'App\Models\Subcategory' => 'App\Policies\UserRolePolicy',
        'App\Models\Product' => 'App\Policies\UserRolePolicy',
        'App\Models\Order' => 'App\Policies\UserRolePolicy',
        'App\Models\Report' => 'App\Policies\UserRolePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
