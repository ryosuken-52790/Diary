<?php

// 入力のチェックをするための場所


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDiary extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'name属性'は必須ですよ〜タイトルは必須だよ。=> 'してほしいチェック'
            // 本文も必須だよ。
            'title' => 'required|max:30',
            'body' => 'required'
            
        ];
    }

    // エラー文言を表示する際の、name属性と表示名の設定をする。
    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'body' => '本文'
        ];
    }
}
