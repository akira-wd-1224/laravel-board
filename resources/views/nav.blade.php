<nav class="navbar navbar-expand navbar-dark peach-gradient">
    {{--navbarでバーの表示navbar-expandでレスポンシブ対応navbar-darkは背景を黒くしてテキストを白く表示peach-gradientは背景色変更--}}
    <a class="navbar-brand" href="/"><i class="fa fa-edit">Board</i></a>
    {{--navbar-brandはブランドを表示--}}
    {{--navbar-navはハンバーガーメニュー--}}
    {{--ml-autoはマージンレフトのオート（右端に寄せるため）--}}
    <ul class="navbar-nav ml-auto">
        {{--nav-itemは部品の構成nav-linkはリンク部品--}}
        @guest
        <li class="nav-item">
            <a class="nav-link" href="{{route('register')}}">ユーザー登録</a>
        </li>
        @endguest
        @guest
        <li class="nav-item">
            <a class="nav-link" href="{{route('login')}}">ログイン</a>
        </li>
        @endguest
        @auth
        <li class="nav-item">
            <a class="nav-link" href="{{route('articles.create')}}"><i class="fas fa-pen mr-1" aria-hidden="true"></i>投稿する</a>
        </li>
        @endauth
        <!-- Dropdown -->
        {{--dropdownはdropdown-toggleやdropdown-menu、dropdown-itemを組み合わせて表示させる。aria-＊”...”は読み上げブラウザなどに付加情報を与えるもの--}}
        @auth
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle"></i>
            </a>
            {{--dropdown-menu-rightは下に出すメニューの表示位置を右に合わせる。buttonタグでの画面遷移はonclick="location.href=''"とする--}}
            <div class="dropdown-menu dropdown-menu-right " aria-labelledby="navbarDropdownMenuLink">
                <button class="dropdown-item" type="button"
                        onclick="location.href=''">
                    マイページ
                </button>
                {{--dropdown-dividerは分割線を表示--}}
                <div class="dropdown-divider"></div>
                <button form="logout-button" class="dropdown-item" type="submit">
                    ログアウト
                </button>
            </div>
        </li>
        {{--レイアウトが崩れるためあえて外にフォームタグを出している--}}
        <form id="logout-button" method="POST" action="{{route('logout')}}">
        @csrf
        </form>
        @endauth
        <!-- Dropdown -->

    </ul>
</nav>
