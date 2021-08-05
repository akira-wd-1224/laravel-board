<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $articles = Article::all()->sortBy('created_at');

        return view('articles.index',['articles'=>$articles]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * 記事の登録
     * @param App\Http\Requests\ArticleRequest
     * @param App\Article
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function store(ArticleRequest $request,Article $article)
    {

        $article->fill($request->all());
        $article->user_id = $request->user()->id;//リクエストのuserメソッドを使うことでUserクラスのインスタンスにアクセスできる
        $article->save();//articlesテーブルにレコードが新規登録される
        return redirect()->route('articles.index');
    }
}
