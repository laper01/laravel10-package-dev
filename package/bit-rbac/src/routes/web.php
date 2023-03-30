<?php
use Danova\BitRbac\Http\Controllers\TestController;
use Danova\BitRbac\Http\Controllers\Auth\GroupController;
use Danova\BitRbac\Http\Controllers\Auth\ModuleController;
use Danova\BitRbac\Http\Controllers\Auth\RoleController;


Route::prefix('test')->group(function () {
    Route::controller(TestController::class)->group(function () {
        Route::get('/', 'index');
    });

    Route::middleware(['auth'])->group(function () {
        Route::prefix('/module')->group(function () {
            Route::controller(ModuleController::class)->group(function () {
                Route::get('/', 'index');
                Route::get('/show/{module}', 'show');
                Route::get('/create', 'create');
                Route::get('/edit/{module}', 'edit');
                Route::get('/delete/{module}', 'destroy');
                Route::post('/update/{module}', 'update');
                Route::post('/store', 'store');
            });
        });
    });

    Route::controller(GroupController::class)->group(function () {

    });



    Route::controller(RoleController::class)->group(function () {

    });
});
