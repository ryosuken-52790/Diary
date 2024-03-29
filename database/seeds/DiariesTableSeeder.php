<?php

use Illuminate\Database\Seeder;
// use=require_once
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DiariesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //こーゆうサンプルを・・・
        //配列でサンプルデータを作っておく
        $diaries = [
            [
                'title' => '初めてのLaravel',
                'body' => 'ムズイ？簡単？',
            ],
            [
                'title' => '初セブ',
                'body' => 'Air Pollution',
            ],
            [
                'title' => 'aiueo',
                'body' => 'まみむめも',
            ],
        ];

        // IDが一番若いユーザーを取得
        $user = DB::table('users')->first();

        // 配列をループで回して、テーブルにINSERTする
        foreach ($diaries as $diary) {

            DB::table('diaries')->insert([
                'title' => $diary['title'],
                'body' => $diary['body'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                // 追加。
                'user_id' => $user->id,

                // => Carbon::now(),は現在時刻をくれる。
            ]);
        }
    }
}

