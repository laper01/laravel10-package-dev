<?php

namespace Danova\BitRbac\Console;

use Illuminate\Console\Command;
use File;
use Danova\BitRbac\Helpers\MenuHellper;
use Illuminate\Database\QueryException;
use App\Models\Auth\Module;


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
        $this->saveModule();
        // ============================
        $menu = new MenuHellper();
        // // dd($menu->filterRoutes('name', 'admin')->filterRoutes('middleware', 'rbac:view')->getRoutes());
        // // dd($menu->filterRoutes('middleware', 'rbac:view')->getRoutes());
        // // dd($this->listFile());
        // // dd($this->listFolder());
        // // dd($menu->filterRoutes('name', '/Test/Test/pembayaran|test modul')->getRoutes());
        // // dd($menu->filterRoutes('module', 'admin')->getRoutes());
        // // dd($menu->listsFolder());
        $menu->repeat();

    }

    public function saveModule(): void
    {
        try {
            $module = Module::upsert(config('module'), ['name'], ['allow_permission', 'author', 'edited', 'folder']);
        } catch (\Exception $error) {
            dd($error);
        }
    }

    public function getFileName(array $allFiles): array
    {
        $filesName = [];
        foreach ($allFiles as $key => $value) {
            if (strpos($value, '.php')) {
                array_push($filesName, str_replace('.php', '', $value));
            }
        }
        return $filesName;
    }

    public function getFoldersPath(array $allFolder): array
    {
        $foldersPath = [];
        foreach ($allFolder as $key => $value) {
            $name = str_replace($this->basepath, '', $value);
            array_push($foldersPath, $name);
        }
        return $foldersPath;
    }

    public function listFolder(): array
    {
        $allFolder = File::directories($this->basepath);
        $foldersPath = $this->getFoldersPath($allFolder);
        return $foldersPath;
    }

    public function listFile(): array
    {
        $files = scandir(base_path('routes'));
        $filesName = $this->getFileName($files);
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
