<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    //TestCaseクラスを継承したクラスでRefreshDatabaseトレイトを使用すると、データベースをリセット
//リセットとはデータベースの全テーブルを削除(DROP)した上で、マイグレーションを実施し全テーブルを作成
//RefreshDatabaseトレイトを使用するとテスト中にデータベースに実行した
//トランザクション(レコードの新規作成・更新・削除など)は、テスト終了後に無かったことになる
    use RefreshDatabase;
    //PHPUnitでは、テストのメソッド名の先頭にtestを付ける必要がある
    //どうしても先頭にtestを記述したくない場合はdocsに@testと記述する
    public function testIndex()
    {
//ここでの$thisは、TestCaseクラスを継承したArticleControllerTestクラスを指す
//TestCaseクラスおよびこれを継承したクラスでは、getメソッドが使用できる
        $response = $this->get(route('articles.index'));
//getメソッドによって変数$responseにIlluminate\Foundation\Testing\TestResponseクラスの
//インスタンスが代入されTestResponseクラスは、assertStatusメソッドが使用できる
//assertStatusメソッドの引数には、HTTPレスポンスのステータスコードを渡す。
//正常レスポンスを示す200を渡し、200であればテストに合格200以外であればテストに不合格となる。
//assertStatus(200)はassertOK()ともかけるがassertOKメソッドは、ステータスコードが200かどうかをテストする。
//assertStatusは、TestResponseクラスのインスタンス自身を返す。
//->で連結させて、そのままTestResponseクラスのメソッドを使用。
//メソッドを連結させて記述することをメソッドチェーンよぶ
        $response->assertStatus(200)
//assertViewIsの引数には、ビューファイル名を渡す。ステータスコードが200かどうかをテストするだけでは、
//記事一覧画面が表示されているかどうかをテストできていない。そのため、ビューについてもテストを行うことにしている。
            ->assertViewIs('articles.index');
    }
}
