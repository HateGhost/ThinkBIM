<?php

use think\facade\Route;

Route::post('login', 'login/index');
Route::post('logout', 'login/logout');
Route::post('refresh/token', 'login/refreshToken');


Route::group(function () {
    Route::get('info/success', 'app\v1\controller\Index@success');
    Route::get('info/error', 'app\v1\controller\Index@error');
})->middleware([
    // app\v1\middleware\AuthTokenMiddleware::class,
    app\v1\middleware\PermissionsMiddleware::class
]);
