<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\ArticleRequest;


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
     * @param ArticleRequest $request
     * @param Article $article
     * @return \Illuminate\Http\RedirectResponse
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
     * @param Article $article
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Article $article)
    {
       return view('articles.edit',['article'=>$article]);
    }

    /**
     * 記事更新処理記事一覧へリダイレクト
     * @param ArticleRequest $request
     * @param Article $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ArticleRequest $request,Article $article)
    {
        $article->fill($request->all())->save();
        return redirect()->route('articles.index');
    }

    /**
     * 記事削除後記事一覧へリダイレクト
     * @param Article $article
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index');
    }

}
