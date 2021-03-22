@extends('layouts.app')


@section('content')

<?php $ss = new Single('Главная', 10, 2); ?>

<section class="mainbanner">
    <div class="image">
        <img src="{{ $ss->field('Баннер', 'Изображение', 'photo', true, '/images/banner.jpg') }}" alt="">
    </div>
    <div class="content">
        <h1>{{ $ss->field('Баннер', 'Заголовок', 'text', true, 'Новая колекция дизайнерской мебели') }}</h1>
        <a href="{{ $ss->field('Баннер', 'Ссылка кнопки', 'text', true, '/') }}" class="btn-empty">{{ $ss->field('Баннер', 'Текст кнопки', 'text', true, 'В коллекцию') }}</a>
    </div>
</section>
@if($topcats)
<section class="categorys">
    <div class="container">
        @foreach($topcats as $tc)
        <a href="{{Lang::link('/products/'.$tc->slug)}}" class="item">
            <img src="{{$tc->img}}" alt="">
            {{$tc->title}}
        </a>
        @endforeach
            @include('inc.salebanner')
    </div>
</section>
@endif

@if($topproducts)
<section class="topproducts">
    <div class="container">
        <span class="top">{{ $ss->field('Хиты продаж', 'Хиты продаж текст', 'text', true, 'Хиты продаж') }}</span>
        <div class="items">
        @foreach($topproducts as $tp)
                <div class="item">
                    <div class="item-hover">
                        <a href="{{Lang::link('/'.$tp->slug)}}"><img src="{{$tp->image}}" alt=""></a>
                        <a href="{{Lang::link('/'.$tp->slug)}}" class="title">{{$tp->title}}</a>
                        <div class="price">
                            <div class="price">{{$tp->sale_price>0 ? $tp->sale_price : $tp->price}} грн</div>
                            @if ($tp->sale_price>0)
                                <div class="oldprice">{{$tp->price}} грн</div>
                            @endif
                        </div>
                        <a href="{{Lang::link('/'.$tp->slug)}}" class="btn-empty-second">Перейти</a>
                        <a href="{{Lang::link('/'.$tp->slug)}}" class="btn catalogaddtocart"
                           data-id="{{$tp->id}}"
                           data-title="{{$tp->title}}"
                           data-price="{{$tp->price}}"
                           data-sale_price="{{$tp->sale_price>0 ? $tp->sale_price : 0}}"
                           data-img="{{$tp->image}}"
                           data-slug="{{$tp->slug}}"
                        >Купить</a>
                    </div>
                </div>
        @endforeach
        </div>
    </div>
</section>
@endif

@include('inc.horizontal')

<section class="about">
    <div class="container">
        <div class="textblock">
            <h2>{{ $ss->field('О нас', 'Заголовок', 'text', true, 'О нас') }}</h2>
            <p>{{ $ss->field('О нас', 'Контент', 'textarea', true, 'Текст о нас') }}
            </p>
            <a href="{{ $ss->field('О нас', 'Ссылка кнопки', 'text', true, '/') }}" class="btn">{{ $ss->field('О нас', 'Текст кнопки', 'text', true, 'Подробнее') }}</a>
        </div>
        <div class="image">
            <img src="{{ $ss->field('О нас', 'Изображение', 'photo', true, '/images/about.png') }}" alt="">
        </div>
    </div>
</section>

@if($topnews)
<section class="news">
    <div class="container">
        <span class="title">{{ $ss->field('Новости и статьи', 'Заголовок', 'text', true, 'Новости и статьи') }}</span>
        @foreach($topnews as $tn)
        <div class="item">
            <a class="image" href="{{Lang::link('/blog/'.$tn->slug)}}">
                <img src="{{$tn->preview_img}}" alt="">
            </a>
            <a href="{{Lang::link('/blog/'.$tn->slug)}}" class="title">{{$tn->title}}</a>
            <span class="date">{{explode(' ',$tn->created_at)[0]}}</span>
            <div class="preview">
                {{$tn->preview}}
            </div>
            <a href="{{Lang::link('/blog/'.$tn->slug)}}" class="btn-empty-second">Читать полностью</a>
        </div>
        @endforeach
    </div>
</section>
@endif

@endsection


@section('meta')

<title>{{ $ss->field('Meta', 'Title', 'textarea', true, 'Digiants') }}</title>
<meta name="description" content="{{ $ss->field('Meta', 'Description', 'textarea', true, '') }}">
<meta name="keywords" content="{{ $ss->field('Meta', 'Keywords', 'textarea', true, '') }}">

@endsection


@section('javascript')


@endsection
