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

Route::name('/admin menu|admin')->prefix('/adminmenu')->group(function () {
    Route::get('1', function () {
        // Route assigned name "admin.users"...
    })->name(':view-menu:test menu admin');
    Route::get('2', function () {
        // Route assigned name "admin.users"...
    })->name(':view-menu:test menu admin2');
});

Route::name('/admin menu2|admin')->prefix('/adminmenu2')->group(function () {
    Route::get('1', function () {
        // Route assigned name "admin.users"...
    })->name(':view-menu:test menu admin3');
    Route::get('2', function () {
        // Route assigned name "admin.users"...
    })->name(':view-menu:test menu admin4');
});


Route::name('/admin menu/child test|admin')->prefix('/adminmenu')->group(function () {
    Route::get('3', function () {
        // Route assigned name "admin.users"...
    })->name(':view-menu:test menu admin5');
    Route::get('4', function () {
        // Route assigned name "admin.users"...
    })->name(':view-menu:test menu admin6');
});

