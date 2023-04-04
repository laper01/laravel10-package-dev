<?php

use Illuminate\Support\Facades\Route;

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
    $routes = Route::getRoutes();
    // dd($routes);
    // return response()->json($routes->);
    return ['Laravel' => app()->version()];
});

Route::get('/test-app',function(){
    return 'ini test';
})->middleware('rbac:view');

require __DIR__.'/auth.php';
