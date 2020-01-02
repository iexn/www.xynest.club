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

// 首页
Route::get('/', 'index/index');

// 意见反馈
Route::get('/feedback', 'Feedback/index');
Route::post('/feedback', 'Feedback/send');

// nes 统计次数
Route::get('game/nes/statistics/times/:id', 'GameFc/stat_times');
// nes主页
Route::get('game/nes/:id/:game_library_id', 'GameFc/detail');
Route::get('game/nes/:id', 'GameFc/start');
Route::get('game/nes', 'GameFc/index');

// 五子棋
Route::get('game/wzq', 'GameOthers/wzq');

// gba主页
Route::get('game/gba/:id', 'GameGba/test');

// flash主页
Route::get('game/flash/:id', 'GameFlash/start');
Route::get('game/flash', 'GameFlash/index');

// 开发专区
Route::get('develop', 'Develop/index');

// gba示例
Route::get('game/gba/:id', 'GameGba/start');

// 实验
Route::get('exp', 'Index/exp');

// 游戏专题、文章
Route::get('game/topic/:id', 'GameTopic/detail');
Route::get('game/topic', 'GameTopic/index');

// 示例
Route::get('demo/1', 'Demo/demo1');
Route::get('demo/2', 'Demo/demo2');
Route::get('demo/3', 'Demo/demo3');
Route::get('demo', 'Demo/index');