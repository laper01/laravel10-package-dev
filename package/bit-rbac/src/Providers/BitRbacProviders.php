<?php

namespace Danova\BitRbac\Providers;

use Illuminate\Support\ServiceProvider;

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
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }
}
