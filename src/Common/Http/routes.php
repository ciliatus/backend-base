<?php

use App\MyProject\Common\Http\Route;

Route::middleware('api')->prefix('api/v1/common')->group(function () {
    Route::post('broadcast/authenticate', '\App\MyProject\Common\Http\Controllers\BroadcastAuthController@authenticate');
    Route::resource('users', App\MyProject\Common\Http\Controllers\UserController::class);
    Route::resource('files', App\MyProject\Common\Http\Controllers\FileController::class);
    Route::get('files/{file}/display/{name?}', 'App\MyProject\Common\Http\Controllers\\FileController@display');
    Route::put('alerts/acknowledge', 'App\MyProject\Common\Http\Controllers\\AlertController@acknowledge');
});
