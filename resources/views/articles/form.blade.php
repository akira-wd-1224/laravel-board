@csrf
<div class="md-form">
    <label>タイトル</label>
    <input type="text" name="title" class="form-control" required value="{{$article->title ?? old('title') }}">
</div>
<div class="form-group">
{{--Bladeからコンポーネントに渡すためにArticleTagsInputコンポーネントには、プロパティInitialTagsを定義して
InitialTagsにタグ情報の入った変数$tagNamesの値を渡す。$tagNames ?? []としているのは、記事入力フォームのBladeであるform.blade.phpが、
createアクションメソッド(記事投稿画面)でも使用されているため。そのため、Blade側では、$tagNamesがnullだった時には空の配列を
ArticleTagsInputコンポーネントに渡せるように考慮--}}
    <article-tags-input
        :initial-tags='@json($tagNames ?? [])'
    >
    </article-tags-input>
</div>
<div class="form-group">
    <label></label>
    <textarea name="body" required class="form-control" rows="16" placeholder="本文">{{$article->body ?? old('body') }}</textarea>
</div>
