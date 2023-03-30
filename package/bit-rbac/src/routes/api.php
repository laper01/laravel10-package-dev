<?php
use Danova\BitRbac\Http\Controllers\TestController;
use Danova\BitRbac\Http\Controllers\Auth\GroupController;
use Danova\BitRbac\Http\Controllers\Auth\ModuleController;
use Danova\BitRbac\Http\Controllers\Auth\RoleController;


Route::prefix('test')->group(function () {
    Route::controller(TestController::class)->group(function () {
        Route::get('/', 'index');
    });

    Route::controller(GroupController::class)->group(function(){

    });

    Route::controller(ModuleController::class)->group(function(){

    });

    Route::controller(RoleController::class)->group(function(){

    });
});
