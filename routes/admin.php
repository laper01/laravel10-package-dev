<?php

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
        ->name(':add')
    ;
});
