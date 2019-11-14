<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 消した
// Route::post('/', 'DiaryController@create');
// このURLがきたとき、これを表示しますよ〜。

Route::get('/', 'DiaryController@index')->name('diary.index');
Route::get('/diary/create', 'DiaryController@create')->name('diary.create');
Route::post('/diary/store', 'DiaryController@store')->name('diary.store');


// ->name('diary.store')のところは好きな名前を入れていい。
// Route::post('/diary/store', 'DiaryController@store')はURLを指す。



// php artisan serve