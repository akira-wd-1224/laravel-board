<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\ArticleRequest;
use App\Tag;
use Illuminate\Http\Request;


class ArticleController extends Controller
{
    /**
     * コンストラクタでauthorizeResourceを呼び出し、各アクションメソッドを処理するかしないか、ポリシーのメソッドで定義した判定条件の通りとなる。
     * @return void
     */
    public function __construct()
    {
        //第一引数にモデル、第二引数にモデルのIDがセットされる、ルーティングのパラメータ名
        $this->authorizeResource(Article::class,'article');
    }

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
        //tagsはArticleRequestで整形したのがコレクションになっている。なのでコレクションメソッドであるeach()は使用できる。
        //each()は引数にコールバック(関数)を渡すことができ、クロージャ(無名関数)としてる。
        //クロージャの第一引数にはコレクションの値が、第二引数にはコレクションのキーが入る。
        //第一引数は$tagName、第二引数は今回のクロージャの中の処理で特に使わないので省略
        //use ($article)はクロージャの中の処理で変数$articleを使うため。
        //クロージャの中では、クロージャの外側で定義されている変数を通常使用できない。
        //使用したい場合は、use (変数名, 変数名, ...)といったように、使う変数名を記述する必要がある。
        $request->tags->each(function($tagName) use ($article) {
            //タグの登録と記事・タグの紐付けを行う。
            //記事と同時にタグを登録するには、そのタグが既にtagsテーブルに存在するタグか、全くの新規のタグかを考慮する。
            //既にtagsテーブルに存在するタグであれば、tagsテーブルに登録する必要は無く、記事とタグの紐付けのみを行えば良い。
            //タグの登録にはfirstOrCreateメソッドを使用し、引数として渡した「カラム名と値のペア」を持つレコードがテーブルに存在するかどうかを探し、
            //もし存在すればそのモデルを返す。テーブルに存在しなければ、そのレコードをテーブルに保存した上で、モデルを返す。
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            //変数$tagにはタグモデルが代入され、記事とタグの紐付け(article_tagテーブルへのレコードの保存)が行われる。
            //eachメソッドによる繰り返し処理によって、これが記事投稿画面で入力されたタグの数だけ行われる。
            $article->tags()->attach($tag);
        });
        return redirect()->route('articles.index');
    }

    /**
     * 記事更新画面の表示
     * @param Article $article
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Article $article)
    {
        //mapは新しいコレクションの作成
        $tagNames = $article->tags->map(function($tag) {
            return ['text' => $tag->name];
        });

        return view('articles.edit',[
            'article' => $article,
            'tagNames' => $tagNames,

        ]);
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

    /**
     * 詳細画面表示
     * @param Article $article
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Article $article)
    {
        return view('articles.show',['article'=> $article]);
    }

    /**
     * @param Request $request
     * @param Article $article
     * @return array
     */
    public function like(Request $request,Article $article)
    {
        //detachは多対多リレーションのヘルパ関数で中間テーブルへの紐付けを解除するメソッド
        //attachも同様のヘルパ関数で中間テーブルへの紐付けをするメソッド
        //先にdetachをする理由は二重に紐付けしないようにするため。仕様上detachでエラーになることはない。
        //vueコンポーネントでも対策はしているが不正なリクエストを行われる可能性を考慮してサーバー側でも対策をする。
        $article->likes()->detach($request->user()->id);
        $article->likes()->attach($request->user()->id);

        //配列を返すことでVeiwにはjson形式で変換されて渡る
        return [
            'id' => $article->id,//どの記事がいいねが成功したかがわかるように記事のモデルのidのレスポンスをする
            'countLikes' => $article->count_likes,//いいね数もレスポンスする。
        ];
    }

    /**
     * @param Request $request
     * @param Article $article
     * @return array
     */
    public function unlike(Request $request,Article $article)
    {
        $article->likes()->detach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }
}
