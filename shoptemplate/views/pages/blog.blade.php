@extends('layouts.app')


@section('content')

    <?php $ss = new Single('Новости', 10, 2); ?>

    <div class="breadcrumbs">
        <ul>
            <li><a href="/">Главная</a></li>
            <li>Новости</li>
        </ul>
    </div>


    <section class="news newspage">
        <div class="container">
            <span class="title">{{ $ss->field('Новости и статьи', 'Новости и статьи', 'text', true, 'Новости и статьи') }}</span>
            <div class="items">
                @foreach ($blog as $article)
                <div class="item">
                    <a class="image" href="{{Lang::link('/blog/'.$article->slug)}}">
                        <img src="{{$article->preview_img}}" alt="">
                    </a>
                    <a href="{{Lang::link('/blog/'.$article->slug)}}" class="title">{{$article->title}}</a>
                    <span class="date">{{explode(' ',$article->created_at)[0]}}</span>
                    <div class="preview">
                        {{$article->preview}}
                    </div>
                    <a href="{{Lang::link('/blog/'.$article->slug)}}" class="btn-empty-second">Читать полностью</a>
                </div>
                @endforeach
            </div>
            @include('inc.pagination', ['pagination' => $pagination])
        </div>
    </section>

@endsection


@section('meta')
    <title>{{ $ss->field('Meta', 'Title', 'textarea', true, 'Digiants') }}</title>
    <meta name="description" content="{{ $ss->field('Meta', 'Description', 'textarea', true, '') }}">
    <meta name="keywords" content="{{ $ss->field('Meta', 'Keywords', 'textarea', true, '') }}">
@endsection


@section('javascript')


@endsection
