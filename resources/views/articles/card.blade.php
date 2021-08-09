<div class="card mt-3">
    <div class="card-body d-flex flex-row">
        <i class="fas fa-user-circle fa-3x mr-1"></i>
        <div>
            <div class="font-weight-bold">
                {{$article->user->name}}
            </div>
            <div class="font-weight-lighter">
                {{$article->created_at->format('Y/m/d/ H:i')}}
            </div>
        </div>
    {{--ログイン中のユーザーidと記事のユーザーidを比較して一致すればメニューを表示--}}
    @if( Auth::id() === $article->user_id )
        <!-- dropdown -->
            <div class="ml-auto card-text">
                <div class="dropdown">
                    {{--data-toggleは何をさせるかを入力　aria-haspopup="true" は要素がポップアップ部品を持つことを、aria-expanded="..." はポップアップの閉塞状態--}}
                    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{--text-mutedは色--}}
                        <button type="button" class="btn btn-link text-muted m-0 p-2">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route("articles.edit", ['article' => $article]) }}">
                            <i class="fas fa-pen mr-1"></i>記事を更新する
                        </a>
                        <div class="dropdown-divider"></div>
                        {{--data-targetはモーダルのリンク先を指定--}}
                        <a class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-delete-{{ $article->id }}">
                            <i class="fas fa-trash-alt mr-1"></i>記事を削除する
                        </a>
                    </div>
                </div>
            </div>
            <!-- dropdown -->

            <!-- modal -->
            {{--modal fadeはモーダルダイアログがフェードイン--}}
            {{--tabindexは要素が入力フォーカスを持てること。負の数はキーボードの順次ナビゲーションで到達できないようにする--}}
            {{--roleは要素に意味づけ　コンピュータに認識させやすくするためのもの--}}
            {{--dialogとは何かを入力させたりメッセージを確認させるために、操作の過程で一時的に開かれる小さい画面のこと--}}
            <div id="modal-delete-{{ $article->id }}" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            {{--class="close"は何かを閉じる--}}
                            {{--data-dismiss="modal"はすべてのアクティブなモーダルを非表示。--}}
                            {{--aria-labelは現在の要素にラベル付けする文字列を定義するために使用。これはテキストラベルが画面に表示されない場合に使用--}}
                            <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                                {{--area-hidden=”true”とは、スクリーンリーダーの読み上げをスキップするための指定--}}
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('articles.destroy', ['article' => $article]) }}">
                            @csrf
                            @method('DELETE')
                            <div class="modal-body">
                                {{ $article->title }}を削除します。よろしいですか？
                            </div>
                            {{--justify-content-betweenはフレックスアイテムの均等配置--}}
                            <div class="modal-footer justify-content-between">
                                <a class="btn btn-outline-grey" data-dismiss="modal">キャンセル</a>
                                <button type="submit" class="btn btn-danger">削除する</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- modal -->
        @endif
    </div>
    <div class="card-body pt-0 pb-2">
        <h3 class="h4 card-title">
            <a class="text-dark" href="{{ route('articles.show', ['article' => $article]) }}">
                {{$article->title}}
            </a>
        </h3>
        <div class="card-text">
            {!! nl2br(e($article->body))!!}
        </div>
        <div class="card-body pt-0 pb-2">
            <div class="card-text">
                {{--:initial-is-liked-byはv-bind:initial-is-liked-byの省略形--}}
                {{--v-bindとは:initial-is-liked-byのような属性を動的に設定できる設定方法--}}
                {{--@jsonはjsonのレンダといい使用することで@json（$article->isLikedBy(Auth::user())）の-}}
                {{--結果の値からjson形式の文字列に変えて-Vueコンポーネントに渡している。--}}
                {{--Auth::check()でログイン状態か確認ができて結果を論理値で返す--}}
                {{--endpointプロパティにはroute関数で得たURLを渡している。URLは固定値なのでv-bindにする必要がない。--}}
                <article-like
                    :initial-is-liked-by='@json($article->isLikedBy(Auth::user()))'
                    :initial-count-likes='@json($article->count_likes)'
                    :authorized='@json(Auth::check())'
                    endpoint="{{ route('articles.like',['article' => $article]) }}">
                </article-like>
            </div>
        </div>
        @foreach($article->tags as $tag)
            {{--$loopは、@foreachの中で使える変数firstとすることでendifまで最初の1回だけ処理が行われる--}}
            @if($loop->first)
                <div class="card-body pt-0 pb-4 pl-3">
                    <div class="card-text line-height">
                        @endif
                        <a href="" class="border p-1 mr-1 mt-1 text-muted">
                            {{ $tag->name }}
                        </a>
                        {{--lastとすると繰り返し処理の最後だけendifまでの処理が行われる--}}
                        @if($loop->last)
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
