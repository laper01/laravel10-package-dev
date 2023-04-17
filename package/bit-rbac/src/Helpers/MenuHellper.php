<?php

namespace Danova\BitRbac\Helpers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use File;

class MenuHellper
{
    protected $routes;
    protected $filteredRoutes;
    protected $folderStack = [];
    protected $filesName = [];

    protected string $path;


    public function __construct()
    {
        $this->routes = collect(Route::getRoutes())->map(function ($route) {
            return [
                'method' => implode('|', $route->methods()),
                'uri' => $route->uri(),
                'name' => $this->getName($route->getName() ?? ''),
                'type' => $this->getType($route->getName() ?? ''),
                // view add update delete
                'menuName' => $this->getMenuName($route->getName() ?? ''),
                'action' => ltrim($route->getActionName(), '\\'),
                'middleware' => collect($route->middleware())
                    ->filter(function (string $string) {
                        return Str::startsWith($string, 'rbac');
                    })->first()
            ];
        });
    }

    public function getFileName(array $allFiles): array
    {
        $filesName = [];
        foreach ($allFiles as $key => $value) {
            array_push($filesName, str_replace('.php', '', $value->getFilename()));
        }
        return $filesName;
    }

    public function getFoldersPath(array $array):array
    {
        $foldersPath =[];
        foreach($array as $key => $value){
            $name = str_replace($this->path, '', $value);
            array_push($foldersPath, $name);
        }
        return $foldersPath;
    }

    public function listsFolder(): array
    {
        $foldersPath = [];
        return $foldersPath;
    }

    public function listFile(): array
    {
        $filesName = [];
        $allfile = File::allFiles($this->path);
        $filesName = $this->getFileName($allfile);
        return $filesName;
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

}
