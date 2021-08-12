<?php

namespace Tests\Feature;

use App\Article;
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
}
