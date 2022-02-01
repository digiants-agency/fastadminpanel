@extends('layouts.app')


@section('content')
    <?php $ss = new Single('Заказ успешно оформлен', 10, 2); ?>

    <div class="breadcrumbs">
        <ul>
            <li><a href="Главная">Главная</a></li>
            <li>Товар</li>
        </ul>
    </div>


    <section class="thxpage">
        <div class="container">
            <h1>{{ $ss->field('Оформление заказа', 'Заголовок', 'text', true, 'Спасибо!') }}</h1>
            <p>{{ $ss->field('Заказ оформлен', 'Заголовок', 'textarea', true, 'Ваш заказ оформлен!') }}</p>
            <p>{{ $ss->field('Мы свяжемся с вами', 'Заголовок', 'textarea', true, 'Мы свяжемся с вами в ближайшее время.') }}</p>
            <a href="{{Lang::link('/')}}" class="btn">На главную</a>
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
