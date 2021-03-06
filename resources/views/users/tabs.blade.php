<ul class="nav nav-tabs nav-justified mt-3">
    <li class="nav-item">
{{--$hasArticlesと$hasLikesを使って、その値によってclass属性に'active'を付加するかどうかを三項演算子で制御--}}
        <a class="nav-link text-muted {{ $hasArticles ? 'active' : '' }}"
           href="{{ route('users.show', ['name' => $user->name]) }}">
            記事
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-muted {{ $hasLikes ? 'active' : '' }}"
           href="{{ route('users.likes', ['name' => $user->name]) }}">
            いいね
        </a>
    </li>
</ul>
