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
    //passedValidationメソッドは、フォームリクエストのバリデーションが成功した後に自動的に呼ばれるメソッド
    //tagsテーブルに必要なのはタグ名だけなので整形してからコントローラーに渡すための処理を定義する
    public function passedValidation()
    {
        //json_decode($this->tags)で、JSON形式の文字列であるタグ情報をPHPのjson_decode関数を使って連想配列に変換
        //Laravelのcollect関数を使ってコレクションに変換
        $this->tags = collect(json_decode($this->tags))
            //sliceメソッドを使うと、コレクションの要素が、第一引数に指定したインデックスから第二引数に指定した数だけになる。
            ->slice(0, 5)
            //mapメソッドは、コレクションの各要素に対して順に処理を行い、新しいコレクションを作成します。
            //なのコールバック引数にはmapで使う要素が入る。コールバックの処理内容は$requestTag->textで戻り値はタグ名になる。
            //mapメソッドによって、コールバックの処理が繰り返されmapメソッドの戻り値はタグ名のコレクションになる。
            ->map(function ($requestTag) {
                return $requestTag->text;
            });
    }
}
