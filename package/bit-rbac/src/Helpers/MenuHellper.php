<?php

namespace Danova\BitRbac\Helpers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class MenuHellper
{
    protected $routes;
    protected $filteredRoutes;


    public function __construct()
    {
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
