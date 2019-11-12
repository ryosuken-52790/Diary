<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diary;
// use App\Diary;が抜けてた・・・・


class DiaryController extends Controller
{
    //
    public function index()
    {
        // diariesテーブルのデータを全件取得
        // 取得した結果を画面で確認

        $diaries = Diary::all();
        // diariesのすべてを勝手に取ってきてくれる
        // dd($diaries);
        // dd():var_dumpとdieが同時に実行されてる

        // views/diaries/index.blade.phpを表示
        // フォルダ名、ファイル名

        return view('diaries.index', [
            // キー => 値
            'diaries' => $diaries
        ]);


    }
}
