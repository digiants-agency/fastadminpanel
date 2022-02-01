@extends('layouts.app')


@section('content')

    <div class="breadcrumbs">
        <ul>
            <li><a href="Главная">Главная</a></li>
            <li>Кабинет пользователя</li>
        </ul>
    </div>


    <section class="cabinet">
        <div class="container">
            <div class="headcab">
                <h1>Личный кабинет</h1>
                <a href="{{Lang::link('/user/logout')}}">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                                d="M13.7852 15.9755H15.5032V19.4111C15.5032 20.832 14.3472 21.9877 12.9264 21.9877H2.57661C1.15596 21.9877 0 20.832 0 19.4111V2.57661C0 1.15596 1.15596 0 2.57661 0H12.9264C14.3472 0 15.5032 1.15596 15.5032 2.57661V6.01227H13.7852V2.57661C13.7852 2.10312 13.4 1.71774 12.9264 1.71774H2.57661C2.10312 1.71774 1.71774 2.10312 1.71774 2.57661V19.4111C1.71774 19.8846 2.10312 20.27 2.57661 20.27H12.9264C13.4 20.27 13.7852 19.8846 13.7852 19.4111V15.9755ZM17.951 6.94482L16.7363 8.15953L18.7117 10.1351H7.60127V11.8528H18.7117L16.7363 13.8282L17.951 15.0429L22 10.994L17.951 6.94482Z"
                                fill="#A0A0A0"/>
                    </svg>
                    Выйти из кабинета
                </a>
            </div>
            <div class="sidebarmenu">
                <ul>
                    <li>
                        <a class="active" data-title="userinfo">Личные данные
                            <svg width="10" height="16" viewBox="0 0 10 16" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                        d="M8.97327 7.26178L8.97347 7.26198C9.1691 7.4573 9.27973 7.72266 9.27973 8.00002C9.27973 8.27661 9.16981 8.54249 8.97326 8.73825L8.97327 7.26178ZM8.97327 7.26178L2.49785 0.804274L2.49775 0.80417C2.0901 0.397886 1.43024 0.398668 1.02346 0.806176L1.02335 0.806291C0.616546 1.21409 0.61775 1.87439 1.02536 2.2809L1.02537 2.28091L6.76031 8.00002L1.02515 13.7191L1.02509 13.7192C0.617574 14.1257 0.61637 14.7857 1.02309 15.1935L1.02325 15.1937C1.22683 15.3976 1.49483 15.5 1.76149 15.5C2.02735 15.5 2.2944 15.3983 2.49772 15.1957L2.49782 15.1956L8.97285 8.73866L8.97327 7.26178Z"
                                        fill="#F39208" stroke="#F39208"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="/user/history" data-title="userhistory">История покупок
                            <svg width="10" height="16" viewBox="0 0 10 16" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                        d="M8.97327 7.26178L8.97347 7.26198C9.1691 7.4573 9.27973 7.72266 9.27973 8.00002C9.27973 8.27661 9.16981 8.54249 8.97326 8.73825L8.97327 7.26178ZM8.97327 7.26178L2.49785 0.804274L2.49775 0.80417C2.0901 0.397886 1.43024 0.398668 1.02346 0.806176L1.02335 0.806291C0.616546 1.21409 0.61775 1.87439 1.02536 2.2809L1.02537 2.28091L6.76031 8.00002L1.02515 13.7191L1.02509 13.7192C0.617574 14.1257 0.61637 14.7857 1.02309 15.1935L1.02325 15.1937C1.22683 15.3976 1.49483 15.5 1.76149 15.5C2.02735 15.5 2.2944 15.3983 2.49772 15.1957L2.49782 15.1956L8.97285 8.73866L8.97327 7.26178Z"
                                        fill="#F39208" stroke="#F39208"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="/user/wishlist" data-title="userwishlist">Избранное
                            <svg width="10" height="16" viewBox="0 0 10 16" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                        d="M8.97327 7.26178L8.97347 7.26198C9.1691 7.4573 9.27973 7.72266 9.27973 8.00002C9.27973 8.27661 9.16981 8.54249 8.97326 8.73825L8.97327 7.26178ZM8.97327 7.26178L2.49785 0.804274L2.49775 0.80417C2.0901 0.397886 1.43024 0.398668 1.02346 0.806176L1.02335 0.806291C0.616546 1.21409 0.61775 1.87439 1.02536 2.2809L1.02537 2.28091L6.76031 8.00002L1.02515 13.7191L1.02509 13.7192C0.617574 14.1257 0.61637 14.7857 1.02309 15.1935L1.02325 15.1937C1.22683 15.3976 1.49483 15.5 1.76149 15.5C2.02735 15.5 2.2944 15.3983 2.49772 15.1957L2.49782 15.1956L8.97285 8.73866L8.97327 7.26178Z"
                                        fill="#F39208" stroke="#F39208"/>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="contentpart userinfo">
                <form action="/" id="userinfoform">
                    <h2>Личные данные</h2>
                    <div class="input_group">
                        <label>Имя*</label>
                        <input type="text" name="name" value="{{$user->name}}" required>
                    </div>
                    <div class="input_group">
                        <label>Фамилия*</label>
                        <input type="text" name="surname" value="{{$user->surname}}">
                    </div>
                    <div class="input_group">
                        <label>E-mail*</label>
                        <input type="email" name="email" value="{{$user->email}}" required>
                    </div>
                    <div class="input_group">
                        <label>Номер телефона</label>
                        <input type="text" name="telephone" value="{{$user->telephone}}">
                    </div>
                    <div class="input_group">
                        <label>Новый пароль</label>
                        <input type="password" name="password" value="">
                    </div>
                    <div class="input_group">
                        <label>Подтвердите новый пароль</label>
                        <input type="password" name="repeatpassword" value="">
                    </div>
                    <input type="submit" class="btn" value="Сохранить изменения">
                    <span class="message"></span>
                </form>
            </div>

            <div class="contentpart userhistory">
                <h2>История заказов</h2>
                <div class="orderslist">
                    @foreach ($orders as $oo)
                        <div class="orderinfo">
                            <div class="allinfo">
                                <span class="ordern">Заказ № {{$oo->id}},</span>
                                <span class="date">{{$oo->created_at}}</span>
                                <span class="status">{{$oo->status}}</span>
                            </div>
                            <div class="sum">
                                <span class="titlesum">Сумма</span>
                                <?php
                                $sum = 0;
                                foreach ($oo->items as $w)
                                    $sum += $w->count * $w->price;
                                ?>
                                <span class="sum">{{$sum}} Br</span>
                            </div>
                        </div>
                        <div class="items">
                            @foreach ($oo->items as $w)
                                <div class="item">
                                    <a href="{{Lang::link('/'.$w->link)}}" class="image">
                                        <img src="{{$w->img}}" alt="">
                                    </a>
                                    <div class="titleattr">
                                        <a href="{{Lang::link('/'.$w->link)}}" class="title">{{$w->title}}</a>
                                        <span class="attr">{{$w->attributes}}</span>
                                    </div>
                                    <div class="qtyinfo">
                                        <span class="qty">{{$w->count}} шт</span>
                                    </div>
                                    <div class="priceblock">
                                        <div class="price">{{$w->price}} Br</div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="orderinf">
                                <span class="del">Способ доставки: {{$oo->deltype}}</span>
                                <span class="del">Способ оплаты: {{$oo->paytype}}</span>
                                <span class="del">Адрес доставки: {{$oo->adress}}</span>
                                <span class="del">Номер телефона: {{$oo->tel}}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="contentpart userwishlist">
                <div class="headcab">
                    <h2>Список желаний</h2>
                    <a href="/user/clearwishlist">Очистить</a>
                </div>
                @foreach($wishlist as $w)
                    <div class="item">
                        <a href="" class="delete"
                           data-id="{{$w->id}}">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                        d="M8.88393 8.00078L15.8169 1.06772C16.061 0.82363 16.061 0.42788 15.8169 0.183818C15.5729 -0.0602445 15.1771 -0.0602757 14.933 0.183818L7.99999 7.11688L1.06697 0.183818C0.822881 -0.0602757 0.427132 -0.0602757 0.18307 0.183818C-0.0609921 0.427912 -0.0610233 0.823661 0.18307 1.06772L7.11609 8.00075L0.18307 14.9338C-0.0610233 15.1779 -0.0610233 15.5737 0.18307 15.8177C0.305101 15.9397 0.465069 16.0007 0.625038 16.0007C0.785006 16.0007 0.944944 15.9397 1.06701 15.8177L7.99999 8.88469L14.933 15.8177C15.055 15.9397 15.215 16.0007 15.375 16.0007C15.5349 16.0007 15.6949 15.9397 15.8169 15.8177C16.061 15.5736 16.061 15.1779 15.8169 14.9338L8.88393 8.00078Z"
                                        fill="#A0A0A0"/>
                            </svg>
                        </a>
                        <a href="{{Lang::link('/'.$w->slug)}}" class="image">
                            <img src="{{$w->img}}" alt="">
                        </a>
                        <div class="titleattr">
                            <a href="{{Lang::link('/'.$w->slug)}}" class="title">{{$w->title}}</a>
                            <span class="attr">{{$w->attr}}</span>
                        </div>
                        <div class="priceblock">
                            @if($w->sale_price>0)
                                <div class="price">{{$w->sale_price}} Br</div>
                                <div class="sale_price">{{$w->price}} Br</div>
                            @else
                                <div class="price">{{$w->price}}</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection


@section('meta')

@endsection


@section('javascript')


@endsection
