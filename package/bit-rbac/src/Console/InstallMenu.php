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

    protected $basepath;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add menu at rbac system';

    public function __construct()
    {
        parent::__construct();
        $this->basepath = base_path('/routes');
    }


    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // ============================
        $menu = new MenuHellper();
        // dd($menu->filterRoutes('name', 'admin')->filterRoutes('middleware', 'rbac:view')->getRoutes());
        // dd($menu->filterRoutes('middleware', 'rbac:view')->getRoutes());
        // dd($this->listFolder());
        // dd($menu->filterRoutes('name', '/Test/Test pembayaran-test modul')->getRoutes());
        // dd($menu->filterRoutes('name', 'admin')->getRoutes());

    }

    public function getFileName(array $allFiles): array
    {
        $filesName = [];
        foreach ($allFiles as $key => $value) {
            array_push($filesName, str_replace('.php', '', $value->getFilename()));
        }
        return $filesName;
    }

    public function getFoldersPath(array $allFolder): array
    {
        $foldersPath =[];
        foreach($allFolder as $key => $value){
            $name = str_replace($this->basepath, '', $value);
            array_push($foldersPath, $name);
        }
        return $foldersPath;
    }

    public function listFolder(): array
    {
        $allFolder = File::directories($this->basepath) ;
        $foldersPath = $this->getFoldersPath($allFolder);
        return $foldersPath;
    }

    public function listFile(): array
    {
        $allfile = File::allFiles($this->basepath);
        $filesName = $this->getFileName($allfile);
        return $filesName;
    }

    public function saveToDatabase(): void
    {
        try {

        } catch (\Exception $e) {
            // return $e;
        }

    }
}
