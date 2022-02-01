@extends('layouts.app')


@section('content')


    <section class="seotext">
        <div class="container">
            <div class="content">
                <h1>Seo Text</h1>
                <p>Ми працюємо у двох напрямках. По-перше, у нас можна купити готові речі від українських дизайнерів. Частина з них має позначку «Ексклюзив» – ці предмети продаються лише у нашому інтернет-магазині. Йдеться про меблі та декор, що ретельно продумані професійними дизайнерами та виготовлені на вітчизняних підприємствах, або в невеликих майстернях. Ви отримуєте високу якість та можливість підібрати унікальні предмети для власного інтер’єру.
                </p><p>
                    Другий напрямок роботи – виготовлення меблів та вирішення нестандартних задач. Багаторічний досвід роботи в інтер’єрних проектах дозволяє нам впевнено сказати, що ми особисто знайомі з кращими українськими меблярами.Ми працюємо у двох напрямках. По-перше, у нас можна купити готові речі від українських дизайнерів. Частина з них має позначку «Ексклюзив» – ці предмети продаються лише у нашому інтернет-магазині. Йдеться про меблі та декор, що ретельно продумані професійними дизайнерами та виготовлені на вітчизняних підприємствах, або в невеликих майстернях. Ви отримуєте високу якість та можливість підібрати унікальні предмети для власного інтер’єру.</p>
                <a href="/" class="btn-empty-second">Подробнее</a>
            </div>
        </div>
    </section>

    <div class="breadcrumbs">
        <ul>
            <li><a href="{{Lang::link('/')}}">Главная</a></li>
            <li>{{isset($category->title) ? $category->title : 'Все товары'}}</li>
        </ul>
    </div>


    <section class="catalogpage">
        <div class="container">
            <h2 class="cattitle">
                {{isset($category->title) ? $category->title : 'Все товары'}}
            </h2>
            @if(Agent::isMobile() && !Agent::isTablet())
            <div class="sidebar_mob">
                @endif
                <div class="sidebar">
                    <div class="mobtitlefilter">
                        <svg width="16" height="8" viewBox="0 0 16 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.646445 4.35355C0.451183 4.15829 0.451183 3.84171 0.646445 3.64645L3.82843 0.464465C4.02369 0.269203 4.34027 0.269203 4.53553 0.464465C4.7308 0.659727 4.7308 0.97631 4.53553 1.17157L1.70711 4L4.53553 6.82843C4.73079 7.02369 4.73079 7.34027 4.53553 7.53553C4.34027 7.7308 4.02369 7.7308 3.82843 7.53553L0.646445 4.35355ZM16 4.5L0.999999 4.5L0.999999 3.5L16 3.5L16 4.5Z" fill="white"/>
                        </svg>
                        Фильтр
                    </div>
                    @foreach($filtergroups as $ff)
                    <div class="filter-block">
                        <span class="title">{{$ff->title}}</span>
                        @foreach($ff->values as $fv)
                        <div class="input-group ">
                            <label class="containercheckbox">{{$fv->title}}
                                <input type="checkbox" value="{{$fv->slug}}" <?php if(stripos($_SERVER['REQUEST_URI'],'f-'.$fv->slug)>0) echo(' checked ');?> >
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                    <div class="filterblock priceslider">
                        <span class="title">Цена</span>
                        <div class="textslider">
                            <div class="from">
                                От <input type="number" id="pricelower" value="0" min="0" max="100000"/>
                            </div>
                            <div class="to">
                                До <input type="number" id="pricehight" value="50000" min="0" max="100000"/>
                            </div>
                        </div>
                        <input type="text" id="priceslider"/>
                    </div>
                    <div class="clear-all">
                        <a href="{{Lang::link('/products'.(isset($category->slug) ? '/'.$category->slug  : ''))}}" class="clearfilter">Сбросить всё</a>
                    </div>
                </div>
                @if(Agent::isMobile() && !Agent::isTablet())
            </div>
            @endif
            <div class="mainblock">
                <!--
                <div class="sort">
                    <span class="title">Сортировать:</span>
                    <ul class="sortlist">
                        <li>По возрастанию цены</li>
                        <li><ul>
                                <li><a href="{{('/products'.(isset($slug) ? '/'.$slug.'?sort=topprice' : '?sort=topprice'))}}">По возрастанию цены</a></li>
                                <li><a href="{{('/products'.(isset($slug) ? '/'.$slug.'?sort=lowerprice' : '?sort=lowerprice'))}}">По убыванию цены</a></li>
                                <li><a href="{{('/products'.(isset($slug) ? '/'.$slug.'?sort=titleasc' : '?sort=titleasc'))}}">От А до Я</a></li>
                                <li><a href="{{('/products'.(isset($slug) ? '/'.$slug.'?sort=titledesc' : '?sort=titledesc'))}}">От Я до А</a></li>
                            </ul></li>
                    </ul>
                </div>
                -->
                <div class="mobfilter">
                    <a href="" class="btn-empty-second">
                        <svg width="13" height="9" viewBox="0 0 13 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.9869 0.855611H5.18616C5.02668 0.381949 4.57867 0.0397339 4.05191 0.0397339C3.52516 0.0397339 3.07714 0.381949 2.91766 0.855611H2.01221C1.80187 0.855611 1.63135 1.02613 1.63135 1.23647C1.63135 1.44681 1.80187 1.61733 2.01221 1.61733H2.91769C3.07717 2.09099 3.52518 2.43321 4.05194 2.43321C4.57869 2.43321 5.02671 2.09099 5.18619 1.61733H10.987C11.1973 1.61733 11.3678 1.44681 11.3678 1.23647C11.3678 1.02613 11.1973 0.855611 10.9869 0.855611ZM4.05191 1.67149C3.81205 1.67149 3.61689 1.47634 3.61689 1.23647C3.61689 0.996605 3.81205 0.801453 4.05191 0.801453C4.29178 0.801453 4.48693 0.996605 4.48693 1.23647C4.48693 1.47634 4.29178 1.67149 4.05191 1.67149Z" fill="#97A38A"/>
                            <path d="M10.9869 4.11913H10.0814C9.92197 3.64547 9.47393 3.30325 8.9472 3.30325C8.42047 3.30325 7.97245 3.64547 7.81297 4.11913H2.01221C1.80187 4.11913 1.63135 4.28965 1.63135 4.49999C1.63135 4.71033 1.80187 4.88085 2.01221 4.88085H7.81297C7.97245 5.35451 8.4205 5.69673 8.94722 5.69673C9.47395 5.69673 9.922 5.35451 10.0815 4.88085H10.987C11.1973 4.88085 11.3678 4.71033 11.3678 4.49999C11.3678 4.28965 11.1973 4.11913 10.9869 4.11913ZM8.94722 4.93501C8.70736 4.93501 8.51221 4.73986 8.51221 4.49999C8.51221 4.26012 8.70736 4.06497 8.94722 4.06497C9.18709 4.06497 9.38224 4.26012 9.38224 4.49999C9.38224 4.73986 9.18709 4.93501 8.94722 4.93501Z" fill="#97A38A"/>
                            <path d="M10.9869 7.38262H6.81794C6.65846 6.90896 6.21044 6.56675 5.68369 6.56675C5.15694 6.56675 4.70892 6.90896 4.54944 7.38262H2.01221C1.80187 7.38262 1.63135 7.55315 1.63135 7.76348C1.63135 7.97382 1.80187 8.14434 2.01221 8.14434H4.54944C4.70892 8.618 5.15694 8.96022 5.68369 8.96022C6.21044 8.96022 6.65846 8.618 6.81794 8.14434H10.987C11.1973 8.14434 11.3678 7.97382 11.3678 7.76348C11.3678 7.55315 11.1973 7.38262 10.9869 7.38262ZM5.68369 8.19852C5.44383 8.19852 5.24867 8.00337 5.24867 7.76351C5.24867 7.52364 5.44383 7.32849 5.68369 7.32849C5.92356 7.32849 6.11871 7.52362 6.11871 7.76348C6.11871 8.00335 5.92356 8.19852 5.68369 8.19852Z" fill="#97A38A"/>
                        </svg>
                        Фильтр</a>
                </div>
                <div class="products topproducts">
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

<title>{{ isset($category->meta_title) ? $category->meta_title : '' }}</title>
<meta name="description" content="{{ isset($category->meta_descr) ? $category->meta_descr : '' }}">

@endsection


@section('javascript')


@endsection
