<?php

namespace Danova\BitRbac\Helpers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use File;
use App\Models\Auth\Routes;
use App\Models\Auth\Module;
use App\Models\Auth\Menu;
use Illuminate\Database\QueryException;

class MenuHellper
{
    protected $routes;
    protected $filteredRoutes;
    protected string $path;
    protected string $basepath;
    protected int $deep = 0;

    protected string $moduleName;
    protected array $filesName;
    protected array $menusSave;
    protected array $routeSave;
    protected array $foldersName;

    protected object $module;

    public function __construct()
    {
        $this->routes = collect(Route::getRoutes())->map(function ($route) {
            return [
                'method' => implode('|', $route->methods()),
                'uri' => $route->uri(),
                'name' => $this->getName($route->getName() ?? ''),
                'type' => $this->getType($route->getName() ?? ''),
                'module' => $this->getModuleName($this->getName($route->getName() ?? '')),
                // module name
                // view add update delete
                'menuName' => $this->getMenuName($route->getName() ?? ''),
                'action' => ltrim($route->getActionName(), '\\'),
                'middleware' => collect($route->middleware())
                    ->filter(function (string $string) {
                        return Str::startsWith($string, 'rbac');
                    })->first()
            ];
        });

        $this->basepath = base_path('/routes');

    }

    public function getFileName(array $allFiles): array
    {
        $filesName = [];
        foreach ($allFiles as $key => $value) {
            array_push($filesName, str_replace('.php', '', $value->getFilename()));
        }
        return $filesName;
    }



    public function getFoldersPath(array $array): array
    {
        $foldersPath = [];
        foreach ($array as $key => $value) {
            $name = str_replace($this->basepath, '', $value);
            array_push($foldersPath, $name);
        }
        return $foldersPath;
    }

    public function listsFolder(): object
    {
        // $foldersPath = [];
        $allFolder = File::directories($this->basepath);
        $this->foldersName = $this->getFoldersPath($allFolder);
        // return $foldersPath;
        return $this;
    }

    public function listFile(): object
    {
        // $filesName = [];
        $allfile = File::allFiles($this->basepath);
        $this->filesName = $this->getFileName($allfile);
        // return $filesName;
        return $this;
    }

    public function getName(string $name = ''): string
    {
        if (strpos($name, ':') !== false) {
            return explode(':', $name)[0];
        }
        return $name;
    }

    public function getType(string $type): string
    {
        if (strpos($type, ':') !== false) {
            return explode(':', $type)[1];
        } else {
            $type = '';
        }

        return $type;
    }

    public function getModuleName(string $name): string
    {
        if (strpos($name, '|') !== false) {
            return explode('|', $name)[1];
        } else {
            $name = '';
        }

        return $name;
    }

    public function getMenuName(string $menuName): string
    {
        if (strpos($menuName, 'view-menu')) {
            return explode(':', $menuName)[2];
        } else {
            $menuName = '';
        }
        return $menuName;
    }

    public function filterRoutes(string $filterKey, string $filterValue): object
    {
        $data = $this->routes->filter(function (array $value, string $key) use ($filterKey, $filterValue) {
            return $value[$filterKey] == $filterValue;
        });
        $this->filteredRoutes = $data;
        return $this;
    }

    public function getRoutes(): Collection
    {
        return $this->filteredRoutes;
    }

    public function findRoute(string $module)
    {
        try {
            $findModule = Module::where('name', $module)->first();
            $this->module = $findModule;
        } catch (QueryException $error) {
            dd($error);
        }

    }

    public function saveRoute(array $route)
    {
        try {
            Route::upsert($route, ['url'], ['url']);
        } catch (QueryException $error) {
            dd($error);
        }
    }

    public function formatRoute(): object
    {

        return $this;
    }

    public function saveMenu(array $menu)
    {
        try {
            Menu::upsert($menu, ['name'], ['name']);
        } catch (QueryException $error) {
            dd($error);
        }

    }

    public function repeat()
    {

    }

}
