@extends('layouts.app')


@section('content')

    <div class="breadcrumbs">
        <ul>
            <li><a href="{{Lang::link('/')}}">Главная</a></li>
            <li>Товар</li>
        </ul>
    </div>

    <?php $ss = new Single('Оформление заказа', 10, 2); ?>

    <section class="orderpage">
        <div class="container">
            <div class="userdata">
                <h1>{{ $ss->field('Оформление заказа', 'Заголовок', 'text', true, 'Оформление заказа') }}</h1>
                <form class="formdata" id="createorder">
                    <span class="title">Личные данные</span>
                    <div class="input-group">
                        <label>Имя и фамилия*</label>
                        <input type="text" name="name" required>
                    </div>
                    <div class="input-group">
                        <label>Номер телефона*</label>
                        <input type="text" name="tel" required>
                    </div>
                    <div class="input-group">
                        <label>Эл. почта для подтверждения заказа*</label>
                        <input type="text" name="email" required>
                    </div>
                    <span class="title">Адрес доставки</span>
                    <div class="input-group">
                        <label>Страна*</label>
                        <input type="text" name="country" required>
                    </div>
                    <div class="input-group">
                        <label>Область*</label>
                        <input type="text" name="region" required>
                    </div>
                    <div class="input-group">
                        <label>Город*</label>
                        <input type="text" name="city" required>
                    </div>
                    <div class="input-group">
                        <label>Введите адрес*</label>
                        <input type="text" name="adress" required>
                    </div>
                    <span class="title">Способ доставки</span>
                    <?php $els = $ss->field('Доставка', 'Методы доставки', 'repeat', true) ?>
                    @foreach ($els as $k=>$elm)
                    <div class="input-radio-full">
                        <?php $name = $elm->field('Заголовок', 'text', '');
                        $time = $elm->field('Сроки', 'text', '5-7 рабочих дней');
                        $price = $elm->field('Цена', 'text', '300 грн');
                        ?>
                        <input type="radio" value="{{$name}}" name="deltype" id="del{{$k}}" <?php if($k==0) echo('checked'); ?>>
                        <span class="checkmark"></span>
                        <label for="del{{$k}}">
                            <div>
                                <span>{{$name}}</span>
                                <span>{{$time}}</span>
                            </div>
                            <span class="delprice">{{$price}}</span>
                        </label>
                    </div>
                        <?php $elm->end() ?>
                    @endforeach
                    <span class="title">Способ оплаты</span>
                    <?php $elss = $ss->field('Оплата', 'Методы оплаты', 'repeat', true) ?>
                    @foreach ($elss as $kk=>$elmm)
                        <?php $name2 = $elmm->field('Заголовок', 'text', '');?>
                    <div class="input-radio">
                        <input type="radio" value="{{$name2}}" name="paytype" id="pay{{$kk}}" <?php if($kk==0) echo('checked'); ?>>
                        <span class="checkmark"></span>
                        <label for="pay{{$kk}}">
                            <span>{{$name2}}</span>
                        </label>
                    </div>
                            <?php $elmm->end() ?>
                    @endforeach

                    <span class="nonrecall">
                        <div class="input-group ">
                            <label class="containercheckbox">
                                <input type="checkbox" name="nonrecall" >
                                <span class="checkmark"></span>
                                Мне можно не звонить для подтверждения заказа
                            </label>
                        </div>
                    </span>
                    <input type="submit" class="btn" value="Подтвердить">
                </form>
            </div>
            <div class="cartdata">
                <h2>Корзина</h2>
                <span class="title">Товары</span>
                <div class="ordercart">
                    <div class="items">

                    </div>
                    <div class="finaltotal">
                        <div class="line"><span>Итого:</span> <p></p></div>
                    </div>
                </div>
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
