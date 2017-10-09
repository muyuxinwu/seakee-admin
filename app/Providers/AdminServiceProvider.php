<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'layouts.sidebar', 'App\Http\ViewComposers\AdminSidebarComposer'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Interfaces\MenuInterface', 'App\Repositories\MenuRepository');
        $this->app->bind('App\Interfaces\UserInterface', 'App\Repositories\UserRepository');
        $this->app->bind('App\Interfaces\RoleInterface', 'App\Repositories\RoleRepository');
        $this->app->bind('App\Interfaces\PermissionInterface', 'App\Repositories\PermissionRepository');
        $this->app->bind('App\Interfaces\IpInterface', 'App\Repositories\IpRepository');
        $this->app->bind('App\Interfaces\RouteInfoInterface', 'App\Repositories\RouteInfoRepository');
	    $this->app->bind('App\Interfaces\CacheInterface', 'App\Repositories\CacheRepository');
    }
}
