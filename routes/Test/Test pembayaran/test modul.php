<?php

Route::name('/Test/Test/pembayaran|test modul')->prefix('testpembayaran')->group(function () {
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
