<?php
use think\facade\Route;

Route::post('login', 'login/index');
Route::post('logout', 'login/logout');
Route::post('refresh/token', 'login/refreshToken');


Route::group(function () {
    Route::get('cc', 'index/cc');
})->middleware([
    app\v1\middleware\AuthTokenMiddleware::class
]);
