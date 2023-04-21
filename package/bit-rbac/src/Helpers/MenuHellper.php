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

    protected ?object $module;

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

        $this->listFile(base_path('/routes'));

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

    public function listFile(string $path): object
    {
        $allfiles = scandir($path);
        $this->filesName = $this->getFileName($allfiles);
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

    public function findModule(array $module)
    {
        try {
            $findModule = Module::where('name', $module)->first();
        } catch (QueryException $error) {
            dd($error);
        }
        return $this;
    }

    public function saveRoute(array $route): object
    {
        try {
            Routes::upsert($route, ['url'], ['url']);
        } catch (QueryException $error) {
            dd($error);
        }

        return $this;
    }

    // kalo ada pathnya ntar di tambahin di depan
    public function formatRoute(object $module): object
    {
        $formatRoute = [];
        $routes = $this->filterRoutes('name', $module->name)->getRoutes();
        // url, module_id, allow_permission
        foreach ($routes as $route) {
            array_push($formatRoute, [
                'url' => $route['uri'],
                'module_id'=>$module->id,
                'allow_permission'=>config('permission.'.$route['type']),
            ]);
        }
        dd($formatRoute);

         $this->routeSave = $formatRoute;
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
        $modules = $this->filesName;
        foreach ($modules as $module) {
            $findModule = Module::where('name', $module)->first();
            if (!$findModule) {
                continue;
            }
            $this->formatRoute($findModule);
        }

        // foreach
    }

}
