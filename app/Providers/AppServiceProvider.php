<?php

namespace App\Providers;

use App\Repository\Classes\RoleRepo;
use App\Repository\Classes\AdminRepo;
use Illuminate\Support\ServiceProvider;
use App\Repository\Interfaces\RoleRepoInterface;
use App\Repository\Interfaces\AdminRepoInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AdminRepoInterface::class, AdminRepo::class);
        $this->app->bind(RoleRepoInterface::class, RoleRepo::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
