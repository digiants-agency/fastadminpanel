@extends('layouts.app')


@section('content')

    @if($products)
        <section class="topproducts">
            <div class="container">
                <span class="top">Поиск по запросу: {{$_GET['s']}}</span>
                <div class="items">
                    @foreach($products as $tp)
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
                @include('inc.pagination', ['pagination' => $pagination])
            </div>
        </section>
    @endif

@endsection


@section('meta')

@endsection


@section('javascript')


@endsection
