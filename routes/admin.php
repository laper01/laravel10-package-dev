<?php

Route::get('/', function () {
    $routes = collect(Route::getRoutes())->map(function ($route) {
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

    $filtered = $routes->filter(function (array $value, string $key) {
        return $value['name'] == 'admin';
    });
    return response()->json($filtered);
    // return ['Laravel' => app()->version()];
});

Route::name('admin')->group(function () {
    Route::get('/users', function () {
        // Route assigned name "admin.users"...
    })
    // ->name('view')
    ;
    Route::get('/users1', function () {
        // Route assigned name "admin.users"...
    });
    Route::get('/test-app', function () {
        return 'ini test';
    })->middleware('rbac:view')
    ->name(':view-menu:test menu name navbar')
    ;

    Route::post('/test-app', function () {
        return 'ini test';
    })->middleware('rbac:add')
    ->name(':view')
    ;
});
