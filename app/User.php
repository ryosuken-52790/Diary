<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


// Usersテーブルを使う為のもの？
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    // ここに接待されたカラム以外には値が設定できないようになる。
    // $fillable : これは決まった名前
    protected $fillable = [
        'name', 'email', 'password', 'picture_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function diaries()
    {
        // $this = usersテーブル
        // usersテーブルは0個以上diariesテーブルのデータを持っている
        // 紐付くDB。。。

        return $this->hasMany('App\Diary');

        
    }
}

// seeder作成
// usersテーブルに