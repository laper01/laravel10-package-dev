<?php

namespace Danova\BitRbac\Console;

use Illuminate\Console\Command;
use Route;


class InstallMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bitrbac-api:install-menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add menu at rbac system';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {

        // ============================

        $routes = Route::getRoutes();
        dd($routes);
    }
}
