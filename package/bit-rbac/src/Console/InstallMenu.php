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
        // $menu = new MenuHellper();
        // dd($menu->filterRoutes('name', 'admin')->filterRoutes('middleware', 'rbac:view')->getRoutes());

        dd($this->listFile());
    }





    public function getFileName($allFiles): array
    {
        $data = [];
        foreach ($allFiles as $key => $value) {
            array_push($data, str_replace('.php', '', $value->getFilename()));
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
        $fileNames = $this->getFileName($allfile);

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
