<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $config_permissions = config("global.permissions");
        foreach ($config_permissions as $name => $value) {
            Gate::define($name, function ($user) use ($name) {
                $user_permissions = $user->role->permissions;
                foreach ($user_permissions as $permission) {
                    // If He Can access
                    if ($permission == $name) {
                        return true;
                    }
                }
                // He Cna't access
                return false;
            });
        }
    }
}
