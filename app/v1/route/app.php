<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;



Route::post('login', 'login/index');
Route::post('logout', 'login/logout');
Route::post('refresh/token', 'login/refreshToken');


Route::group(function () {
    Route::get('cc', 'index/cc');
})->middleware([app\v1\middleware\AuthTokenMiddleware::class]);


