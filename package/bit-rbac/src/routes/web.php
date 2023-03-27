<?php
use Danova\BitRbac\Http\Controllers\TestController;


// Route::group(['namespace'=>'Danova\BitRbac\Http\Controllers'], function(){
//     Route::get('test', )
// });

Route::controller(TestController::class)->group(function(){
    Route::get('test', 'index');
});
