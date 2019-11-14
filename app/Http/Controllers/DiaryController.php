<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diary;
// use App\Diary;が抜けてた・・・・

// 上はDiaryモデルの宣言
// CreateDiaryを使用する宣言
use App\Http\Requests\CreateDiary;


class DiaryController extends Controller
{
    //一覧画面を表示するためのメソッド
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

    // Laravelの公式メソッド
    // 日記の作成画面を表示する
    public function create()
    {
        return view('diaries.create');
    }


    // 新しい日記の保存をする画面
    // 投稿が押されると、ここへ飛んでくるよ！

    public function store(CreateDiary $request)
    {
        //Diaryモデルのインスタンスを作成
        $diary = new Diary();

        // Diaryモデルを使って、DBに日記を保存
        // ddはvar_dumpとdieを使う意。
        // dd($request->title);

        // $diary->カラム名 = カラムに設定したい値
        $diary->title = $request->title;
        $diary->body = $request->body;

        // DBに保存実行
        $diary->save();
        

        // 一覧ページにリダイレクト
        // これをやると二重投稿を防ぐことができる。
        return redirect()->route('diary.index');

    }

    // 日記を削除するためのメソッド
    public function destroy(int $id)
    {
        // dd($id);
        // これを使った時に「削除」を押すと、id番号が表示された。



        // Diaryモデルを使用して、IDが一致する日記を取得
        // id ○番の日記を取ってくる。
        $diary = Diary::find($id);

        // 取得した日記の確認
        $diary->delete();

        // 一覧画面にリダイレクト
        return redirect()->route('diary.index');


    }
}
