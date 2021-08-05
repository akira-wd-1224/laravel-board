@if ($errors->any())
{{--$errorsはIlluminate\Support\MessageBagクラスのインスタンス--}}
{{--any()はMessageBagクラスのメソッドでエラーメッセージの有無を返す--}}
    <div class="card-text text-left alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
