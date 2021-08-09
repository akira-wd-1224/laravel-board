@csrf
<div class="md-form">
    <label>タイトル</label>
    <input type="text" name="title" class="form-control" required value="{{$article->title ?? old('title') }}">
</div>
<div class="form-group">
{{--Bladeからコンポーネントに渡すためにArticleTagsInputコンポーネントには、プロパティInitialTagsを定義して
InitialTagsにタグ情報の入った変数$tagNamesの値を渡す。$tagNames ?? []としているのは、記事入力フォームのBladeであるform.blade.phpが、
createアクションメソッド(記事投稿画面)でも使用されているため。そのため、Blade側では、$tagNamesがnullだった時には空の配列を
ArticleTagsInputコンポーネントに渡せるように考慮。$allTagNameも同様。$allTagNamesがnullであることを考慮する必要は無がいいねが
もしnullが発生した状態を想定して画面は表示できるけれど自動補完がされない状態にする。--}}
    <article-tags-input
        :initial-tags='@json($tagNames ?? [])'
        :autocomplete-items='@json($allTagNames ?? [])'
    >
    </article-tags-input>
</div>
<div class="form-group">
    <label></label>
    <textarea name="body" required class="form-control" rows="16" placeholder="本文">{{$article->body ?? old('body') }}</textarea>
</div>
