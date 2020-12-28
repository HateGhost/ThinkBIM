<?php

use think\facade\Route;

Route::post('login', 'login/index');
Route::post('logout', 'login/logout');
Route::post('refresh/token', 'login/refreshToken');


Route::group(function () {
    Route::get('cc', 'app\v1\controller\Index@index');
    Route::get('ccw', 'app\v1\controller\api\Index@index');
})->middleware([
    // app\v1\middleware\AuthTokenMiddleware::class,
    app\v1\middleware\PermissionsMiddleware::class
]);
