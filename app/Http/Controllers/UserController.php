<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param string $name
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $name)
    {
        //nameはユニーク制約なのでwhereを使用しても最大１件しか取得できない。
        //whereはコレクションを返すのでfirstを使用し１件分のモデルを取得し$userに代入
        $user = User::where('name', $name)->first()
            //ユーザーモデルのリレーション先の記事(投稿した記事)の、さらにリレーション先の、記事を投稿したユーザー
            //記事にいいねしたユーザー,記事に付けられたタグををEagerロードする。
            //.区切りを使って、リレーション先の、さらにリレーション先をEagerロードできる。
            ->load(['articles.user', 'articles.likes', 'articles.tags']);
        $articles = $user->articles->sortBy('created_at');
        //Viewメソッドでブレードを指定し、モデルが入った$userを渡す
        return view('users.show', [
            'user' => $user,
            'articles' => $articles,
        ]);
    }

    /**
     * @param string $name
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function likes(string $name)
    {
        $user = User::where('name', $name)->first()
            ->load(['likes.user', 'likes.likes', 'likes.tags']);
        $articles = $user->likes->sortBy('created_at');
        return view('users.likes', [
            'user' => $user,
            'articles' => $articles,
        ]);
    }

    /**
     * @param string $name
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function followings(string $name)
    {
        $user = User::where('name', $name)->first()
            //ユーザーモデルのリレーション先のフォロー中ユーザーの、さらにリレーション先の、フォロワーをEagerロード
            ->load('followings.followers');
        $followings = $user->followings->sortByDesc('created_at');

        return view('users.followings', [
            'user' => $user,
            'followings' => $followings,
        ]);
    }

    /**
     * @param string $name
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function followers(string $name)
    {
        $user = User::where('name', $name)->first()
            ->load('followers.followers');
        $followers = $user->followers->sortByDesc('created_at');

        return view('users.followers', [
            'user' => $user,
            'followers' => $followers,
        ]);
    }

    /**
     * @param Request $request
     * @param string $name
     * @return string[]|void
     */
    //引数$nameはルートから{name}の部分が渡される。{name}はフォローされる側のユーザーの名前が入る
    public function follow(Request $request, string $name)
    {
        //フォローされるユーザーのモデル１件の取得。nameはユニーク制約なのでwhereで２件以上なることはない。
        $user = User::where('name', $name)->first();

        //フォローされる側のユーザーのidと、フォローのリクエストを行なったユーザーのidを比較
        if ($user->id === $request->user()->id)
        {
            //tureならabort関数を使ってエラーのHTTPステータスコードをレスポンス
            //第一引数にステータスコード。ステータスコード404は、ユーザーからのリクエストが誤っている場合などに使われるエラー
            //第二引数にはクライアントにレスポンスするテキストを渡す（省略可能）
            return abort('404', 'Cant follow yourself.');
        }
        //followingsメソッドは、多対多のリレーション(BelongsToManyクラスのインスタンス)が返る
        //1人のユーザーがあるユーザーを複数回重ねてフォローできないようにするため削除(detach)してから新規登録(attach)
        $request->user()->followings()->detach($user);
        $request->user()->followings()->attach($user);
        //非同期通信に対するレスポンス
        //コントローラーのアクションメソッドで配列や連想配列を返すと、JSON形式に変換されてレスポンスされる
        //どのユーザーへのフォローが成功したかがわかるようにユーザーの名前を返す
        return ['name' => $name];
    }

    /**
     * @param Request $request
     * @param string $name
     * @return string[]|void
     */
    public function unfollow(Request $request, string $name)
    {
        $user = User::where('name', $name)->first();

        if ($user->id === $request->user()->id)
        {
            return abort('404', 'Cannot follow yourself.');
        }

        $request->user()->followings()->detach($user);

        return ['name' => $name];
    }
}
