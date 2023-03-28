<?php

namespace Danova\BitRbac\Providers;

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


        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallBitRBAC::class
            ]);
        }

        // $this->commands([
        //     Console\InstallBitRBAC::class,
        // ]);
    }

    public function provides()
    {
        return [InstallBitRBAC::class];
    }
}
