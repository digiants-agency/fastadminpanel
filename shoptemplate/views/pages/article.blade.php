@extends('layouts.app')


@section('content')
    <?php $ss = new Single('Статья', 10, 2); ?>

    <div class="breadcrumbs">
        <ul>
            <li><a href="/">Главная</a></li>
            <li><a href="/blog/">Блог</a></li>
            <li>{{$article->title}}</li>
        </ul>
    </div>

    <section class="articlepage">
        <div class="container">
            <h1>{{$article->title}}</h1>
            <span class="date">{{explode(' ',$article->created_at)[0]}}</span>
            <div class="content">
                {!! $article->content !!}
            </div>
        </div>
    </section>


    <section class="news">
        <div class="container">
            <span class="title">{{ $ss->field('Читайте также', 'Читайте также', 'text', true, 'Читайте также') }}</span>
            <div class="items">
                @foreach ($blog as $art)
                    <div class="item">
                        <a class="image" href="{{Lang::link('/blog/'.$art->slug)}}">
                            <img src="{{$art->preview_img}}" alt="">
                        </a>
                        <a href="{{Lang::link('/blog/'.$art->slug)}}" class="title">{{$art->title}}</a>
                        <span class="date">05/27/2015</span>
                        <div class="preview">
                            {{$art->preview}}
                        </div>
                        <a href="{{Lang::link('/blog/'.$art->slug)}}" class="btn-empty-second">Читать полностью</a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection


@section('meta')
<!--
<title></title>
<meta name="description" content="">
-->
@endsection


@section('javascript')


@endsection
