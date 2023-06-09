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
    protected array $foldersName;
    protected int $parent_position = 1;
    protected int $menu_id = 1;

    protected array $formatMenuNames;
    protected array $routeSave;

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
                'path' => $this->getModulePath($this->getName($route->getName() ?? '')),
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

    public function getModulePath(string $name): string
    {
        if (strpos($name, '|') !== false) {
            return explode('|', $name)[0];
        } else {
            $name = '';
        }
        return $name;
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

    public function varFilterRoute(Collection $route, string $filterKey, string $filterValue): Collection
    {
        $data = $route->filter(function (array $value, string $key) use ($filterKey, $filterValue) {
            return $value[$filterKey] == $filterValue;
        });

        return $data;
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

    public function saveRoute(): object
    {
        try {
            Routes::upsert($this->routeSave, ['url'], ['module_id', 'allow_permission']);
        } catch (QueryException $error) {
            dd($error);
        }

        return $this;
    }

    // kalo ada pathnya ntar di tambahin di depan
    public function formatRoute(object $module): object
    {
        $formatRoute = collect();
        $routes = $this->filterRoutes('module', $module->name)->getRoutes();

        foreach ($routes as $route) {
            $formatRoute->push([
                'url' => $route['uri'],
                'module_id' => $module->id,
                'allow_permission' => config('permission.' . $route['type']),
            ]);
        }

        $this->routeSave = $formatRoute->toArray();
        return $this;
    }

    public function getFormatedRoutes(): array
    {
        return $this->routeSave;
    }

    public function saveMenu()
    {
        try {
            Menu::upsert($this->formatMenuNames, ['id', 'name'], ['position', 'parent_menu_id', 'module_id', 'url']);
        } catch (QueryException $error) {
            dd($error);
        }
        return $this;
    }

    public function formatMenu(object $module): object
    {
        $menus = $this->varFilterRoute($this->filteredRoutes, 'type', 'view-menu')->sortBy('path');
        $formatedMenus = collect();
        $child_position = 0;
        $prePath = '';
        foreach ($menus as $index => $menu) {
            $position = $this->parent_position;
            $name = $menu['menuName'];
            $parent_menu_id = null;
            $modul_id = $module->id;
            $url = $menu['uri'];
            $array_path = explode('/', $menu['path']);
            $ln_arr_path = count($array_path);
            // check if menu contain parent
            // properti data menu yang perlu didisi: id, depth, position, name, type, parent_menu_id, modul_id, url
            if (strpos($menu['path'], '/') !== false) {
                if ($ln_arr_path === 2) {
                    // cari parent menu pabila tidak ada buat
                    $parent_group_path = $array_path[$ln_arr_path - 1];
                    $parent_group = $formatedMenus->firstWhere('path', '/' . $parent_group_path);
                    if ($parent_group === null) {
                        $formatedMenus->push([
                            'id' => $this->menu_id,
                            'position' => ++$position,
                            'name' => $parent_group_path,
                            'parent_menu_id' => $parent_menu_id,
                            'module_id' => $modul_id,
                            'url' => '#',
                            'path' => $menu['path'],
                        ]);
                        $parent_menu_id = $this->menu_id;
                        $prePath = $menu['path'];
                        ++$this->parent_position;
                        ++$this->menu_id;
                        $child_position = 0;
                    }
                    if ($parent_group) {
                        $parent_menu_id = $parent_group['id'];
                    }
                    // cek jika menu path sama dengan sebelumnya jika ya postion+1 jika tidak mulai dari awal
                    if ($prePath === $menu['path']) {
                        ++$child_position;
                        $position = $child_position;
                    } else {
                        ++$child_position;
                        $position = $child_position;
                    }
                } else if ($ln_arr_path > 2) {
                    // dengan ada system ini berarti tidak boleh melakukan penulisan lebih dari satu path route sekaligus secara langsung tanpa menulis path pertama sendiri diawal
                    // kenapa ini dilakukan unutk menghidari loop berlebih pada system
                    // use firstWhere to find path in collection
                    // dd($ln_arr_path);
                    $child_group_path = $array_path[$ln_arr_path - 1];
                    $parent_group_path = $array_path[$ln_arr_path - 2];
                    $parent_group = $formatedMenus->firstWhere('path', '/' . $parent_group_path);
                    $child_group = $formatedMenus->firstWhere('path', '/' . $parent_group_path . '/' . $child_group_path);
                    if ($parent_group === null) {
                        throw new \Exception('parent group id pada menu null' . $parent_group_path);
                    }
                    if ($child_group === null) {
                        $formatedMenus->push([
                            'id' => $this->menu_id,
                            'position' => ++$position,
                            'name' => $child_group_path,
                            'parent_menu_id' => $parent_group['id'],
                            'module_id' => $modul_id,
                            'url' => '#',
                            'path' => $menu['path'],
                        ]);
                        $parent_menu_id = $this->menu_id;
                        $prePath = $menu['path'];
                        ++$this->parent_position;
                        ++$this->menu_id;
                        $child_position = 0;
                    }
                    if ($child_group) {
                        $parent_menu_id = $child_group['id'];
                    }
                    if ($prePath === $menu['path']) {
                        ++$child_position;
                        $position = $child_position;
                    } else {
                        ++$child_position;
                        $position = $child_position;
                        $child_position = 0;
                    }
                } else {
                    ++$this->parent_position;
                }
            }
            // detemine child or not
            $formatedMenus->push([
                'id' => $this->menu_id,
                'position' => $position,
                'name' => $name,
                'parent_menu_id' => $parent_menu_id,
                'module_id' => $modul_id,
                'url' => $url,
                'path' => $menu['path'],
            ]);
            $prePath = $menu['path'];
            ++$this->menu_id;

        }
        // dd($menus);

        $removePath = $formatedMenus->map(function($item){
            unset($item['path']);
            return $item;
        }) ;
        $this->formatMenuNames = $removePath->toArray();
        return $this;
    }

    public function getFormatedMenus(): array
    {
        return $this->formatMenuNames;
    }

    public function repeat()
    {
        // tinggal buat save untuk masing masing route dan menu menggunakan upsert
        $modules = $this->filesName;
        foreach ($modules as $module) {
            $findModule = Module::where('name', $module)->first();
            if (!$findModule) {
                continue;
            }
            $testRoute = $this->formatRoute($findModule)->saveRoute()->formatMenu($findModule)->saveMenu();
            // dd($testRoute);
            // $testMenus = $this->formatRoute($findModule)->formatMenu($findModule)->getFormatedMenus();
        }

        // foreach
    }

}
