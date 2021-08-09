<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    //引数$nameはルーティングに定義したURL/tags/{name}の{name}の部分に入った文字列が渡る
    public function show(string $name)
    {
        //whereメソッドを使って、$nameと一致するタグ名を持つタグモデルをコレクションで取得
        //firstメソッドを使ってコレクションから最初のタグモデル1件を取り出し、変数$tagに代入
        $tag = Tag::where('name', $name)->first();
        //Bladeにはタグモデルの入った変数$tagを渡す
        return view('tags.show', ['tag' => $tag]);
    }
}
