<?php

use think\facade\Route;

Route::get('/', 'index/index');
Route::get('read', 'index/read');
Route::get('link', 'link/index');
Route::get('message', 'message/index');
Route::any('callback', 'callback/index');
Route::get('login', 'login/index');
Route::get('logout', 'login/out');

