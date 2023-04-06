<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $routes = collect(Route::getRoutes())->map(function ($route) {
        return [
            'method' => implode('|', $route->methods()),
            'uri' => $route->uri(),
            'name' => $route->getName(),
            'action' => ltrim($route->getActionName(), '\\'),
            'middleware' => collect($route->middleware())
            ->filter( function(string $string){
                return Str::startsWith($string, 'rbac');
            })->first()
        ];
    });

    $filtered = $routes->filter(function (array $value, string $key) {
        return $value['name'] == 'admin';
    });
    return response()->json($filtered);
    // return ['Laravel' => app()->version()];
});

Route::name('admin')->group(function () {
    Route::get('/users', function () {
        // Route assigned name "admin.users"...
    });
    Route::get('/users1', function () {
        // Route assigned name "admin.users"...
    });
    Route::get('/test-app', function () {
        return 'ini test';
    })->middleware('rbac:view');

    Route::post('/test-app', function () {
        return 'ini test';
    })->middleware('rbac:add');
});



require __DIR__ . '/auth.php';
