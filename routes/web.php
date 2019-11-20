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
Auth::routes();




// １。新規登録後/home
// 新規投稿や編集などはログインしないとできないようにする。


Route::group(['middleware' => ['auth']], function (){
// この中に書かれたルートはログインしないと見れないように設定できる。


    Route::get('/diary/create', 'DiaryController@create')->name('diary.create');
    Route::post('/diary/store', 'DiaryController@store')->name('diary.store');
                // ->name('diary.store')のところは好きな名前を入れていい。
                // Route::post('/diary/store', 'DiaryController@store')はURLを指す。
    Route::delete('/diary/{id}', 'DiaryController@destroy')->name('diary.destroy');
                // {id}が変わるようにしたい。 // 日記が入ってくる。
    Route::get('/diary/{diary}/edit', 'DiaryController@edit')->name('diary.edit');
                // 今書いたものはなんなんだろう？
    Route::put('/diary/{id}/update', 'DiaryController@update')->name('diary.update');
                // putはリソースの更新。
                // いくつかあるHTTPなんちゃらw


    Route::post('/diary/{id}/like', 'DiaryController@like')->name('diary.like');
    Route::post('/diary/{id}/dislike', 'DiaryController@dislike')->name('diary.dislike');


});
