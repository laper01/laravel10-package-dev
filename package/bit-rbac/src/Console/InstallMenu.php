<?php

namespace Danova\BitRbac\Console;

use Illuminate\Console\Command;
use File;
use Danova\BitRbac\Helpers\MenuHellper;



class InstallMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $file;
    protected $folder;

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
        // $routes = Route::getRoutes();
        // dd($routes);
        // dd($this->filterRoutes('name', 'admin'));
        // dd($this->filterRoutes('middleware', 'rbac:view'));
        $menu = new MenuHellper();
        dd($menu->filterRoutes('name', 'admin')->filterRoutes('middleware', 'rbac:view')->getRoutes());
    }





    public function propOfFile($allFiles): array
    {
        $data = [];
        foreach ($allFiles as $key => $value) {
            array_push($data, $value->getFilename());
        }

        return $data;
    }

    public function propOfFolder(): array
    {
        return [];
    }

    public function listFolder(): void
    {

    }

    public function listFile(): array
    {
        $allfile = File::allFiles(base_path('/routes'));
        $fileNames = $this->propOfFile($allfile);

        return $fileNames;
    }

    public function saveToDatabase(): void
    {
        try {

        } catch (\Exception $e) {
            // return $e;
        }

    }
}
