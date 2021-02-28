<?php


use App\MyProject\Common\Http\Route;

Route::middleware('api')->prefix('api/v1/auth')->group(function () {
    Route::get('check', 'App\MyProject\Api\Http\Controllers\AuthController@check__show');
});
