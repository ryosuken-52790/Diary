<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diary;
// use App\Diary;が抜けてた・・・・


// 上はDiaryモデルの宣言
// CreateDiaryを使用する宣言
use App\Http\Requests\CreateDiary;


// ログイン情報を管理する
use Illuminate\Support\Facades\Auth;





class DiaryController extends Controller
{
    //一覧画面を表示するためのメソッド
    public function index()
    {
        // diariesテーブルのデータを全件取得
        // 取得した結果を画面で確認

        // $diaries = Diary::all();
        // これだと日記の投稿のみを取ってくる。



        $diaries = Diary::with('likes')->orderBy('id', 'desc')->get();



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



    // storeメソッド
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
        $diary->user_id = Auth::user()->id;
        // dd(Auth::user());
        // // これを書くだけで、情報を取ってくる。ユーザーの
        // これでDBのtitle,body,user_idに Auth~ のユーザー情報を入れますよ。になる！！！



        // DBに保存実行
        $diary->save();


        // 一覧ページにリダイレクト
        // これをやると二重投稿を防ぐことができる。
        return redirect()->route('diary.index');

    }




    // destroyメソッド
    // 日記を削除するためのメソッド
    public function destroy(int $id)
    {
        // dd($id);
        // これを使った時に「削除」を押すと、id番号が表示された。
        // Diaryモデルを使用して、IDが一致する日記を取得
        // id ○番の日記を取ってくる。
        $diary = Diary::find($id);

        if(Auth::user()->id != $diary->user_id) 
        {
            abort(403);
        }

        // 取得した日記の確認
        $diary->delete();

        // 一覧画面にリダイレクト
        return redirect()->route('diary.index');


    }



    // editメソッド
    // 編集画面を表示する
    public function edit(Diary $diary)
    {
        // ログインyユーザーが日記の投稿者かチェックする
        if(Auth::user()->id != $diary->user_id) 
        {
            abort(403);
        }
        // ここに書くことでreturnを返す前にチェックしますよ。の意


        // 受け取ったIDを元に日記を取得。
        // $diary = Diary::find($id);

        return view('diaries.edit',[
            'diary'=> $diary
        ]);
        // 編集画面を返す。同時に画面に取得した日記を渡す
        // これは表示するためのもので
        // それらはresourcesのviewsに入れるのが鉄則。
        // diariesの。。。に入ってるから、この書き方！

    }



    // 日記を更新し、一覧画面をリダイレクトする
    // -$id : 編集対象の日記のID
    // -$request : リクエストの内容、ここに画面で入力された文字が格納されている。
    public function update(int $id, CreateDiary $request)
    {
        // dd($request->title);
        // この段階で編集に飛んでから、「投稿」を押すと、タイトルをリクエストしてるからそれが画面の一番上に黒い棒状の所に表示される。

        // 受け取ったIDを元に日記を取得
        $diary = Diary::find($id);

        if(Auth::user()->id != $diary->user_id) 
        {
        //  投稿者とログインユーザーが違う場合
            abort(403);
        }

        // ヒントはstoreメソッド！
        // 取得した日記のタイトル、本文を書き換える
        $diary->title = $request->title;
        // 更新したい日記の。。。requestでもらってきたものを代入
        $diary->body = $request->body;

        // DBに保存
        $diary->save();

        // 一覧ページにリダイレクト
        return redirect()->route('diary.index');


    }

    // いいねが押された時
    // このIDはweb.phpのルートから来てる。
    public function like(int $id)
    {
        // いいねされた日記の取得
        $diary = Diary::find($id);

        // attach : 多対多のデータを登録するメソッド
        // 今回のlikesのデータをDBに登録させてる。
        $diary->likes()->attach(Auth::user()->id);

        // 通信が成功したことを返す
        return response()->json(['success' => 'いいね完了！']);

    }


    // いいね解除が押された時の処理
    public function dislike(int $id)
    {
        // いいね解除された日記の取得
        $diary = Diary::find($id);

        // detach : 多対多のデータを削除するメソッド
        $diary->likes()->detach(Auth::user()->id);

        // 通信が成功したことを返す
        return response()->json(['success' => 'いいね解除完了！']);

    }
}



// memo
// Authorized... は、権利。つまり、ログインをしろと