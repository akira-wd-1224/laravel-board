<?php

namespace Tests\Feature;

use App\Article;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testIsLikedByNull()
    {
        //factory(Article::class)->create()とすることで、ファクトリによって生成されたArticleモデルがデータベースに保存
        $article = factory(Article::class)->create();
        //$articleがisLikedByメソッドを使用。引数としてnullを渡し、その戻り値が変数$resultに代入
        $result = $article->isLikedBy(null);
        //assertFalseメソッドは、引数がfalseかどうかをテスト
        $this->assertFalse($result);
    }

    public function testIsLikedByTheUser()
    {
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();
        //likesテーブルのレコードが新規登録
        $article->likes()->attach($user);

        $result = $article->isLikedBy($user);

        $this->assertTrue($result);
    }

    public function testIsLikedByAnother()
    {
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();
        $another = factory(User::class)->create();
        //自分ではない他人が記事に「いいね」をする
        $article->likes()->attach($another);
        //$userは、この$articleをいいねしていないユーザー
        $result = $article->isLikedBy($user);

        $this->assertFalse($result);
    }
}
