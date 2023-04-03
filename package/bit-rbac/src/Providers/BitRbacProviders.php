<?php

namespace Danova\BitRbac\Providers;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\ServiceProvider;

use Danova\BitRbac\Console\InstallBitRBAC;

class BitRbacProviders extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */

    public function boot()
    {
        //
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        Route::middleware('api')->prefix('api')->group(function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        });

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallBitRBAC::class
            ]);
        }

        // publish config file
        $this->publishes([
            __DIR__.'/../config/menusDefault.php' => config_path('menuDefault.php'),
            __DIR__.'/../config/rbacBinAddress.php' => config_path('rbacBinAddress.php')
        ]);
    }

    public function provides()
    {
        return [InstallBitRBAC::class];
    }
}
