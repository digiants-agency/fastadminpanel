@extends('layouts.app')

@section('content')

    <?php $ss = new Single('О нас', 10, 2); ?>

    <div class="breadcrumbs">
        <ul>
            <li><a href="/">Главная</a></li>
            <li>О нас</li>
        </ul>
    </div>

    <section class="aboutpage">
        <div class="container">
            <h1>{{ $ss->field('Первый блок', 'Заголовок', 'text', true, 'О компании') }}</h1>
            <div class="content">
                <img src="{{ $ss->field('Первый блок', 'Изображение', 'photo', true, '/images/aboutbanner.jpg') }}" alt="">
                <p>{{ $ss->field('Первый блок', 'Описание', 'textarea', true, 'О компании') }}</p>
            </div>
        </div>
    </section>

    <section class="aboutitems">
        <div class="container">
            <span class="title">{{ $ss->field('Преимущества', 'Наши преимущества', 'text', true, 'Наши преимущества') }}</span>
            <div class="items">
                <?php $els = $ss->field('Преимущества', 'Преимущества2', 'repeat', true) ?>
                @foreach ($els as $elm)
                <div class="item">
                    <div class="icon">
                        <img src="{{$elm->field('Иконка', 'photo', '/images/abouticon.svg')}}" alt="">
                    </div>
                    <span class="titleitem">{{$elm->field('Описание', 'text', 'Бесплатная доставка')}}</span>
                    <p>{{$elm->field('Описание 2', 'text', 'в пункты выдачи')}}</p>
                </div>
                        <?php $elm->end() ?>
                @endforeach
            </div>
        </div>
    </section>

    <section class="history">
        <div class="container">
            <div class="textblock">
                <span class="title">{{ $ss->field('Наша история', 'Заголовок', 'text', true, 'Наша история') }}</span>
                {!!  $ss->field('Наша история', 'Контент', 'ckeditor', true, '')  !!}
            </div>
            <div class="imgblock">
                <img src="{{ $ss->field('Наша история', 'Изображение', 'photo', true, '/images/history.jpg') }}" alt="">
            </div>
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
