<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * 記事一覧画面の表示
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $articles = Article::all()->sortBy('created_at');

        return view('articles.index',['articles'=>$articles]);
    }

    /**
     * 記事投稿画面の表示
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * 記事の登録の処理後記事一覧画面へリダイレクト
     * @param App\Http\Requests\ArticleRequest $request
     * @param App\Article $article
     * @return   Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|Illuminate\Routing\Redirector
     */
    public function store(ArticleRequest $request,Article $article)
    {

        $article->fill($request->all());
        $article->user_id = $request->user()->id;//リクエストのuserメソッドを使うことでUserクラスのインスタンスにアクセスできる
        $article->save();//articlesテーブルにレコードが新規登録される
        return redirect()->route('articles.index');
    }

    /**
     * 記事更新画面の表示
     * @param App\Article $article
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|App\Article
     */
    public function edit(Article $article)
    {
       return view('articles.edit',['article'=>$article]);
    }

    /**
     * 記事更新処理記事一覧へリダイレクト
     * @param App\Http\Requests\ArticleRequest $request
     * @param App\Article $article
     * @return   Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|Illuminate\Routing\Redirector
     */
    public function update(ArticleRequest $request,Article $article)
    {
        $article->fill($request->all())->save();
        return redirect()->route('articles.index');
    }

}
