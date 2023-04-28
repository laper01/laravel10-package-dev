<?php


Route::name('/Test|test modul')->prefix('test-modul')->group(function () {
    Route::get('/users', function () {
        // Route assigned name "admin.users"...
    })->name(':view-menu:test menu modul');
    Route::get('/users1', function () {
        // Route assigned name "admin.users"...
    })->middleware('rbac:view')
        ->name(':view');
    Route::get('/test-app', function () {
        return 'ini test';
    })->middleware('rbac:view')
        ->name(':view');

    Route::post('/test-app', function () {
        return 'ini test';
    })->middleware('rbac:add')
        ->name(':add');
});

Route::name('/Test/Test pembayaran|test modul')->prefix('testpembayaran')->group(function () {
    Route::get('/users', function () {
        // Route assigned name "admin.users"...
    })->middleware('rbac:view')
        ->name(':view');
    Route::get('/users1', function () {
        // Route assigned name "admin.users"...
    })->middleware('rbac:view')
        ->name(':view');
    Route::get('/test-app', function () {
        return 'ini test';
    })->middleware('rbac:view')
        ->name(':view-menu:test menu pembayaran')
    ;

    Route::post('/test-app', function () {
        return 'ini test';
    })->middleware('rbac:add')
        ->name(':add');
});
