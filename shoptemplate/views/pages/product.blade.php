@extends('layouts.app')


@section('content')


    <style>
        /* Slider */
        .slick-slider {
            position: relative;

            display: block;
            box-sizing: border-box;

            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;

            -webkit-touch-callout: none;
            -khtml-user-select: none;
            -ms-touch-action: pan-y;
            touch-action: pan-y;
            -webkit-tap-highlight-color: transparent;
        }

        .slick-list {
            position: relative;

            display: block;
            overflow: hidden;

            margin: 0 auto;
            padding: 0;
        }

        .slick-list:focus {
            outline: none;
        }

        .slick-list.dragging {
            cursor: pointer;
            cursor: hand;
        }

        .slick-slider .slick-track,
        .slick-slider .slick-list {
            -webkit-transform: translate3d(0, 0, 0);
            -moz-transform: translate3d(0, 0, 0);
            -ms-transform: translate3d(0, 0, 0);
            -o-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
        }

        .slick-track {
            position: relative;
            top: 0;
            left: 0;

            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .slick-track:before,
        .slick-track:after {
            display: table;

            content: '';
        }

        .slick-track:after {
            clear: both;
        }

        .slick-loading .slick-track {
            visibility: hidden;
        }

        .slick-slide {
            display: none;
            float: left;

            height: 100%;
            min-height: 1px;
        }

        [dir='rtl'] .slick-slide {
            float: right;
        }

        .slick-slide img {
            display: block;
            max-width: 100%;
            width: 100%;
        }

        .slick-slide.slick-loading img {
            display: none;
        }

        .slick-slide.dragging img {
            pointer-events: none;
        }

        .slick-initialized .slick-slide {
            display: block;
        }

        .slick-loading .slick-slide {
            visibility: hidden;
        }

        .slick-vertical .slick-slide {
            display: block;

            height: auto;

            border: 1px solid transparent;
        }

        .slick-arrow.slick-hidden {
            display: none;
        }

        /* Arrows */
        .slick-prev,
        .slick-next {
            font-size: 0;
            line-height: 0;

            position: absolute;
            top: 50%;

            display: block;

            width: 20px;
            height: 20px;
            padding: 0;
            -webkit-transform: translate(0, -50%);
            -ms-transform: translate(0, -50%);
            transform: translate(0, -50%);

            cursor: pointer;

            color: transparent;
            border: none;
            outline: none;
            background: transparent;
        }

        .slick-prev:hover,
        .slick-prev:focus,
        .slick-next:hover,
        .slick-next:focus {
            color: transparent;
            outline: none;
            background: transparent;
        }

        .slick-prev:hover:before,
        .slick-prev:focus:before,
        .slick-next:hover:before,
        .slick-next:focus:before {
            opacity: 1;
        }

        .slick-prev.slick-disabled:before,
        .slick-next.slick-disabled:before {
            opacity: .25;
        }

        .slick-prev:before,
        .slick-next:before {
            font-family: 'slick';
            font-size: 20px;
            line-height: 1;

            opacity: .75;
            color: white;

            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .slick-prev {
            left: -25px;
        }

        [dir='rtl'] .slick-prev {
            right: -25px;
            left: auto;
        }

        .slick-prev:before {
            content: 'в†ђ';
        }

        [dir='rtl'] .slick-prev:before {
            content: 'в†’';
        }

        .slick-next {
            right: -25px;
        }

        [dir='rtl'] .slick-next {
            right: auto;
            left: -25px;
        }

        .slick-next:before {
            content: 'в†’';
        }

        [dir='rtl'] .slick-next:before {
            content: 'в†ђ';
        }

        /* Dots */
        .slick-dotted.slick-slider {
            margin-bottom: 30px;
        }

        .slick-dots {
            position: absolute;
            bottom: -25px;

            display: block;

            width: 100%;
            padding: 0;
            margin: 0;

            list-style: none;

            text-align: center;
        }

        .slick-dots li {
            position: relative;

            display: inline-block;

            width: 20px;
            height: 20px;
            margin: 0 5px;
            padding: 0;

            cursor: pointer;
        }

        .slick-dots li button {
            font-size: 0;
            line-height: 0;

            display: block;

            width: 20px;
            height: 20px;
            padding: 5px;

            cursor: pointer;

            color: transparent;
            border: 0;
            outline: none;
            background: transparent;
        }

        .slick-dots li button:hover,
        .slick-dots li button:focus {
            outline: none;
        }

        .slick-dots li button:hover:before,
        .slick-dots li button:focus:before {
            opacity: 1;
        }

        .slick-dots li button:before {
            font-family: 'slick';
            font-size: 6px;
            line-height: 20px;

            position: absolute;
            top: 0;
            left: 0;

            width: 20px;
            height: 20px;

            content: '\2022';
            text-align: center;

            opacity: .25;
            color: black;

            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .slick-dots li.slick-active button:before {
            opacity: .75;
            color: black;
        }
    </style>

    <div class="breadcrumbs">
        <ul>
            <li><a href="{{Lang::link('/')}}">Главная</a></li>
            <li><a href="{{Lang::link('/products/'.$category->slug)}}">{{$category->title}}</a></li>
            <li>{{$product->title}}</li>
        </ul>
    </div>


    <section class="productpage">
        <div class="container">
            <div class="maininfo">
                <h1>{{$product->title}}</h1>
                <div class="slider">
                    <div class="mainslider">
                        <div>
                            <img src="{{$product->image}}" alt="">
                        </div>
                        @foreach($product->gallery as $pg)
                            <div>
                                <img src="{{$pg}}" alt="">
                            </div>
                        @endforeach
                    </div>
                    <div class="navslider">
                        <div>
                            <img src="{{$product->image}}" alt="">
                        </div>
                        @foreach($product->gallery as $pg)
                            <div>
                                <img src="{{$pg}}" alt="">
                            </div>
                        @endforeach
                    </div>
                    <div class="navsliderbtns">
                        <div class="sliderbtn prevbtn">
                            <svg width="12" height="20" viewBox="0 0 12 20" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.826885 9.45117L10.0775 0.226167C10.3806 -0.0759023 10.8713 -0.0753945 11.1738 0.227729C11.4762 0.530814 11.4754 1.02179 11.1723 1.32409L2.47231 10L11.1726 18.6759C11.4757 18.9783 11.4765 19.4689 11.1742 19.7721C11.0225 19.924 10.8238 20 10.6251 20C10.4268 20 10.2289 19.9245 10.0775 19.7736L0.826885 10.5489C0.680909 10.4036 0.598995 10.206 0.598995 10C0.598995 9.7941 0.681144 9.59668 0.826885 9.45117Z"
                                      fill="#1E1E1E"/>
                            </svg>
                        </div>
                        <div class="sliderbtn nextbtn">
                            <svg width="12" height="20" viewBox="0 0 12 20" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1731 9.45117L1.92252 0.226167C1.61944 -0.0759023 1.12874 -0.0753945 0.826162 0.227729C0.52382 0.530814 0.524601 1.02179 0.827725 1.32409L9.52769 10L0.827412 18.6759C0.524327 18.9783 0.523546 19.4689 0.82585 19.7721C0.977529 19.924 1.17624 20 1.37495 20C1.57315 20 1.77108 19.9245 1.92249 19.7736L11.1731 10.5489C11.3191 10.4036 11.401 10.206 11.401 10C11.401 9.7941 11.3189 9.59668 11.1731 9.45117Z"
                                      fill="#1E1E1E"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="productinfo">
                    @if(count($mods)>0)
                        <div class="mods">
                            <span class="title">Модификации</span>
                            <ul>
                                @foreach($mods as $k=>$m)
                                    <label class="containerfilter">
                                        <input name="modselector" type="radio" class="changeoffer"
                                               value="{{$m->id}}" data-title="{{$m->title_mod}}"
                                               <?php if($k == 0) :?>checked=""<?php endif;?> >
                                        <span class="checkmarkfilter">{{$m->title_mod}}</span>
                                    </label>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($product->short_descr)
                        <div class="descr">
                            <span class="title">{{$product->title_short_descr}}</span>
                            <p>{{$product->short_descr}}</p>
                        </div>
                    @endif

                    <div class="qtyblock">
                        <span class="minusqty">-</span>
                        <input id="qtyproduct" type="number" min="1" max="40" value="1" readonly="">
                        <span class="plusqty">+</span>
                    </div>
                    <div class="priceandbuy">
                        <div class="prices">
                            <div class="price">
                                <div class="price">{{$product->sale_price>0 ? $product->sale_price : $product->price}}
                                    грн
                                </div>
                                @if($product->sale_price>0)
                                    <div class="oldprice">{{$product->price}} грн</div>
                                @endif
                            </div>
                            <div class="av">
                                @if($product->available)
                                    <span class="available">В наличии</span>
                                @else
                                    <span class="available error">Не в наличии</span>
                                @endif
                            </div>
                        </div>
                        <div class="buyoneclick">
                            <form action="" method="post" id="buyoneclick">
                                <div class="left">
                                    <label for="oneclickbuy">Купить в один клик</label>
                                    <input type="text" name="tel" id="oneclickbuy" placeholder="+380 __ - ___ - __ - __"
                                           required>
                                    <input type="hidden" name="id" value="{{$product->id}}">
                                </div>
                                <input type="submit" class="btn" value="" id="buyoneclicksend">
                                <label for="buyoneclicksend" class="btn buyoneclicksend">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M23.347 17.6136L19.9977 14.2643C18.8015 13.0681 16.768 13.5466 16.2896 15.1016C15.9307 16.1782 14.7346 16.7763 13.658 16.537C11.2657 15.9389 8.03602 12.8289 7.43794 10.3169C7.07908 9.24035 7.79679 8.04418 8.87334 7.68538C10.4284 7.20691 10.9068 5.17343 9.71066 3.97726L6.36138 0.627988C5.40445 -0.209329 3.96905 -0.209329 3.13173 0.627988L0.859009 2.90071C-1.41371 5.29304 1.09824 11.6327 6.72023 17.2547C12.3422 22.8767 18.6819 25.5083 21.0743 23.1159L23.347 20.8432C24.1843 19.8863 24.1843 18.4509 23.347 17.6136Z"
                                              fill="white"/>
                                    </svg>
                                </label>
                            </form>
                        </div>
                    </div>
                    <div class="btns">
                        @if($product->available)
                            <a href="" class="btn addtocart addtocartproductpage"
                               data-id="{{$product->id}}"
                               data-title="{{$product->title}}"
                               data-price="{{$product->price}}"
                               data-sale_price="{{$product->sale_price>0 ? $product->sale_price : 0}}"
                               data-img="{{$product->image}}"
                               data-slug="{{$product->slug}}"
                            >Купить</a>
                        @endif
                        <a href="" class="btn addtowish"
                           data-id="{{$product->id}}"
                           data-title="{{$product->title}}"
                           data-price="{{$product->price}}"
                           data-sale_price="{{$product->sale_price>0 ? $product->sale_price : 0}}"
                           data-img="{{$product->image}}"
                           data-slug="{{$product->slug}}"
                        >
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.5948 5.20013L14 5.76037L14.4051 5.20015C14.9047 4.50948 15.4677 3.92255 16.0846 3.44538C17.3019 2.50406 18.6749 2.03125 20.1782 2.03125C22.2026 2.03125 24.0576 2.83995 25.4111 4.30804C26.7505 5.76086 27.5 7.75885 27.5 9.94586C27.5 12.1705 26.6778 14.229 24.8381 16.4486L24.8381 16.4487C23.177 18.4532 20.7793 20.4985 17.9475 22.9116L17.9475 22.9116L17.9235 22.9321C16.9659 23.7483 15.8799 24.674 14.7529 25.6596L14.7526 25.6598C14.5449 25.8417 14.2775 25.9423 14 25.9423C13.7224 25.9423 13.4552 25.8418 13.247 25.6594L13.2467 25.6591C12.1114 24.6666 11.0184 23.735 10.0562 22.9148L10.0532 22.9123L10.0531 22.9123C7.22095 20.4987 4.82327 18.4532 3.16208 16.4489C1.32241 14.229 0.5 12.1704 0.5 9.94608C0.5 7.75886 1.2495 5.76086 2.58864 4.30804C3.94221 2.83996 5.79739 2.03125 7.82181 2.03125C9.32509 2.03125 10.6982 2.50408 11.9153 3.44541L11.9153 3.44543C12.5323 3.92258 13.0956 4.5097 13.5948 5.20013Z"
                                      fill="white" stroke="#97A38A"/>
                                <clipPath id="clip0">
                                    <rect width="28" height="28" fill="white"/>
                                </clipPath>
                            </svg>
                        </a>
                            <span class="wishinfo"></span>

                    </div>
                </div>
            </div>
            @if(count($attrs)>0)
                <div class="kharakteristics">
                    <h2>Характеристики</h2>
                    @foreach($attrs as $atr)
                        <div class="row">
                            <div class="title">
                                {{$atr->grouptitle}}
                            </div>
                            <div class="value">
                                {{$atr->filtertitle}}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if($product->description)
                <div class="description">
                    <h2>Описание</h2>
                    <div class="descrtext">
                        {!! $product->description !!}
                    </div>
                </div>
            @endif

            <div class="testims">
                <h2>Отзывы</h2>
                <div class="listreviews">
                    @if(count($product->testims)>0)
                        @foreach($product->testims as $pt)
                            <div class="review">
                                <div class="userinfo">

                                    <div class="review_header">
                                        <div class="photo">
                                            <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="25" cy="25" r="25" fill="#5C155A"/>
                                                <path d="M25.3218 25.0426C26.9762 25.0426 28.4088 24.4492 29.5794 23.2785C30.7499 22.1079 31.3433 20.6757 31.3433 19.0211C31.3433 17.367 30.7499 15.9346 29.5792 14.7637C28.4085 13.5934 26.976 13 25.3218 13C23.6672 13 22.2349 13.5934 21.0644 14.7639C19.8939 15.9344 19.3003 17.3669 19.3003 19.0211C19.3003 20.6757 19.8939 22.1081 21.0646 23.2787C22.2353 24.449 23.6677 25.0426 25.3218 25.0426Z" fill="white"/>
                                                <path d="M35.8579 32.2239C35.8241 31.7367 35.7558 31.2054 35.6553 30.6442C35.5538 30.0789 35.4232 29.5444 35.2668 29.056C35.1052 28.5511 34.8855 28.0525 34.6139 27.5747C34.332 27.0788 34.0009 26.647 33.6293 26.2917C33.2408 25.9199 32.7651 25.621 32.215 25.403C31.6668 25.1862 31.0593 25.0763 30.4095 25.0763C30.1543 25.0763 29.9075 25.181 29.4309 25.4913C29.1375 25.6826 28.7944 25.9039 28.4114 26.1486C28.0839 26.3573 27.6402 26.5528 27.0923 26.7298C26.5576 26.9028 26.0148 26.9905 25.479 26.9905C24.9432 26.9905 24.4006 26.9028 23.8654 26.7298C23.318 26.553 22.8743 26.3575 22.5472 26.1488C22.1679 25.9064 21.8245 25.6851 21.5268 25.4911C21.0507 25.1808 20.8037 25.0761 20.5485 25.0761C19.8985 25.0761 19.2912 25.1862 18.7432 25.4032C18.1935 25.6208 17.7176 25.9197 17.3287 26.2919C16.9574 26.6474 16.6261 27.079 16.3445 27.5747C16.0731 28.0525 15.8534 28.5509 15.6917 29.0562C15.5354 29.5446 15.4048 30.0789 15.3033 30.6442C15.2028 31.2046 15.1345 31.7362 15.1008 32.2244C15.0676 32.7028 15.0508 33.1993 15.0508 33.7007C15.0508 35.0057 15.4656 36.0622 16.2837 36.8414C17.0916 37.6102 18.1607 38.0003 19.4608 38.0003H31.4984C32.7985 38.0003 33.8672 37.6104 34.6753 36.8414C35.4936 36.0628 35.9084 35.0061 35.9084 33.7005C35.9082 33.1968 35.8912 32.6999 35.8579 32.2239Z" fill="white"/>
                                                <clipPath id="clip0">
                                                    <rect width="25" height="25" fill="white" transform="translate(13 13)"/>
                                                </clipPath>
                                            </svg>

                                        </div>
                                        <div class="name">
                                            <p class="name">{{ $pt->name }}</p>
                                            <span class="date">{{ explode(' ', $pt->created_at)[0] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="testimcontent">
                                    <p>{{ $pt->note }}</p>
                                </div>
                            </div>
                            @if($pt->answer)
                            <div class="answer">
                                <div class="answer_header">
                                    <div class="answer_header_inner">Відповідь від власника</div>
                                    <div class="answer_header_date">{{ explode(' ', $pt->updated_at)[0] }}</div>
                                </div>
                                <div class="answer_text">
                                        {{ $pt->answer }}
                                </div>
                            </div>
                            @endif
                        @endforeach
                    @else
                        <div class="review empty">
                            <span>Отзывов к данному товару ещё нет. Вы можете оставить первый. </span>
                        </div>
                    @endif
                </div>
                <div class="formreviews">
                    <span class="h2">Оставить отзыв</span>
                    <form action="" method="post" id="addtestim">
                        <input type="text" name="name" placeholder="Ваше имя" required>
                        <input type="text" name="tel" placeholder="Ваш номер телефона" required>
                        <input type="text" name="email" placeholder="Ваш email" required>
                        <input type="hidden" name="id_product" value="{{$product->id}}" required>
                        <textarea name="note" placeholder="Сообщение"></textarea>
                        <input type="submit" class="btn" value="Отправить">
                        <div class="message"></div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @if($topproducts)
        <section class="topproducts">
            <div class="container">
                <span class="top">Хиты продаж</span>
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


@endsection


@section('meta')

    <title>{{ $product->meta_title }}</title>
    <meta name="description" content="{{ $product->meta_title }}">

@endsection


@section('javascript')


@endsection
