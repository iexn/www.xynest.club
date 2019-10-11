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

// Route::domain('admin')->middleware('auth');

// 首页
Route::get('/', 'Index/index');

// 登录页
Route::get('login', 'login/index');
Route::get('login/index', 'login/index');

// 登录
Route::post('login/signin', 'login/signin');

// 登出
Route::post('login/signout', 'login/signout');


Route::get('nes/library', 'nes/index');
Route::get('nes/list', 'nes/index');