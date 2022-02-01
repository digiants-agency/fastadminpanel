@extends('layouts.app')


@section('content')
    <?php $ss = new Single('Доставка и оплата', 10, 2); ?>
    <div class="breadcrumbs">
        <ul>
            <li><a href="/">Главная</a></li>
            <li>Доставка и оплата</li>
        </ul>
    </div>

    <section class="articlepage">
        <div class="container">
            <h1>{{ $ss->field('Доставка и оплата', 'Заголовок', 'text', true, 'Доставка и оплата') }}</h1>
            <div class="content">
                {!!  $ss->field('Доставка и оплата', 'Контент', 'ckeditor', true, 'Доставка и оплата')  !!}
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
