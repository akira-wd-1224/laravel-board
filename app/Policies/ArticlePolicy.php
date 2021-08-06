<?php

namespace App\Policies;

use App\Article;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

//このポリシーはArticleモデルに対応したもの、対応するアクションメソッドの実行を許可して良い「条件」を追加する。返り値はboolにする。
//ポリシーでfalseとなった場合は対応するアクションメソッドは処理されず、403（ユーザーに権限が無しのエラー）のHTTPレスポンスが返される
class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any articles.
     *
     * @param  \App\User|null  $user
     * @return mixed|bool
     */
    //対応するコントローラーのアクションメソッドはindex、?Userと定義して未ログインユーザーのことも考慮する
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the article.
     *
     * @param  \App\User|null  $user
     * @param  \App\Article  $article
     * @return mixed|bool
     */
    //?Userと定義して未ログインユーザーのことも考慮する
    public function view(?User $user, Article $article)//show
    {
        return true;
    }

    /**
     * Determine whether the user can create articles.
     *
     * @param  \App\User  $user
     * @return mixed|bool
     */
    public function create(User $user)//create,storeこれらはまだ記事モデルが作られていないことを想定するためture
    {
        return true;
    }

    /**
     * Determine whether the user can update the article.
     *　ユーザーにより指定されたポストが更新可能か決める
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed|bool
     */
    public function update(User $user, Article $article)//edit,update
    {
        return $user->id === $article->user_id;
    }

    /**
     * Determine whether the user can delete the article.
     *　ユーザーにより指定されたポストが更新可能か決める
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed|bool
     */
    public function delete(User $user, Article $article)//destroy
    {
        return $user->id === $article->user_id;
    }

    /**
     * Determine whether the user can restore the article.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    public function restore(User $user, Article $article)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the article.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    public function forceDelete(User $user, Article $article)
    {
        //
    }
}
