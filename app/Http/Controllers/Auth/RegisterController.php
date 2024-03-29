<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
// 新規アカウント作成に関わるコントローラー
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    // ここの設定が、どこに飛ぶかログイン後

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            // 画像の種類と大きさを設定。
            // 詳しくは公式をチェック
            // 2048は画像サイズ。
        ]);
        // ここが勝手にエラー表示を出してくれている。
        // 〇〇は必須入力だよ！
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $imgPath = 
            $this->saveProfileImage(($data['picture']));
        // dd($imgPath);

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'picture_path' => $imgPath,
        ]);
    }

    // プロフィール画像を保存するためのメソッド
    // 引数 $image : 保存したい画像をもらってくるイメージ
    // メソッドは書いてるだけ。実行はまた別。
    // 実行は上のcreateでやる！！
    private function saveProfileImage($image)
    {
        $imgPath = $image->store('images/profilePicture', 'public');
        // ララベルがstoreで絶対被らないように設定してくれてる。
        // 保存した後、そのファイルまでのパスを返してくれる。
        // ちなみにファイルはstorage/public/images/profilePicture

        return 'strategy/' . $imgPath;
    }
}
