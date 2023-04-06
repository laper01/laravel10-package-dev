<?php

namespace Danova\BitRbac\Console;

use Illuminate\Console\Command;
use File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;


class InstallMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $file;
    protected $folder;
    protected $routes;

    protected $signature = 'bitrbac-api:install-menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add menu at rbac system';

    public function __construct()
    {
        parent::__construct();
        $this->routes = collect(Route::getRoutes())->map(function ($route) {
            return [
                'method' => implode('|', $route->methods()),
                'uri' => $route->uri(),
                'name' => $route->getName(),
                'action' => ltrim($route->getActionName(), '\\'),
                'middleware' => collect($route->middleware())
                    ->filter(function (string $string) {
                        return Str::startsWith($string, 'rbac');
                    })->first()
            ];
        });
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {

        // ============================
        // $routes = Route::getRoutes();
        // dd($routes);
        dd($this->routes);
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
