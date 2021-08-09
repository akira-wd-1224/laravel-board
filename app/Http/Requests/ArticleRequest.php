<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;//ユーザーが更新して良いかどうかを判定
    }

    /**
     * Get the validation rules that apply to the request.
     * キーにパラメーターを、値にバリデーションルールを指定
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required','max:50'],
            'body' => ['required','max:500'],
            //rulesメソッド内にjsonを指定し、JSON形式かどうかのバリデーションを行う
            'tags' => 'json|regex:/^(?!.*\s).+$/u|regex:/^(?!.*\/).*$/u',
        ];
    }

    /**
     * バリデーションエラーメッセージに表示される項目名をカスタマイズ
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'body' => '本文',
            'tags' => 'タグ',
        ];
    }
}
