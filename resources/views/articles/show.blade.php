@extends('app')

@section('title', '詳細画面')

@section('content')

@include('nav')

    <div class="container">
        @include('articles.card')
    </div>

@endsection
