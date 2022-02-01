@extends('layouts.app')


@section('content')
    <div class="breadcrumbs">
        <ul>
            <li><a href="/">Главная</a></li>
            <li>{{$page->title}}</li>
        </ul>
    </div>

    <section class="articlepage">
        <div class="container">
            <h1>{{ $page->title }}</h1>
            <div class="content">
                {!! $page->content !!}
            </div>
        </div>
    </section>
@endsection


@section('meta')
    <title>{{ $page->meta_title }}</title>
    <meta name="description" content="{{ $page->meta_description }}">
    <meta name="keywords" content="{{ $page->meta_keywords }}">
@endsection


@section('javascript')


@endsection
