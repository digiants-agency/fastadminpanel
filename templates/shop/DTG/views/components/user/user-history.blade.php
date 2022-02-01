<div class="user-content user-history @if($active) active @endif">

    <div class="h4 color-second user-history-title">{{ $fields['title'] }}</div>

    <div class="user-orders">
        @if(sizeof($orders))
            @foreach ($orders as $order)
                <div class="user-order">
                    <div class="user-order-header">
                        <div class="user-order-header-left">
                            <div class="main-text color-text order-title">{{ $fields['order_title'] }} №{{ $order->id_order }}, <span class="main-text color-grey order-date">{{ date_format( date_create($order->date), 'd.m.Y H:i') }}</span></div>
                            <div class="extra-text order-status @if($order->status->id == 5) success @elseif($order->status->id == 4) error @else new @endif">{{ $order->status->title }}</div>
                        </div>
                        <div class="user-order-header-right">
                            <div class="main-text color-grey order-title-sum">{{ $fields['sum_title'] }}</div>
                            <div class="color-text order-sum">{{ $order->sum }} {{ $fields['currency'] }}</div>
                        </div>
                    </div>
                    <div class="order-products-wrapper">
                        @foreach ($order->products as $product)
                            <div class="order-product">

                                <a href="{{ route('product', $product->slug, false) }}" class="order-product-photo-wrapper">
                                    <img src="{{ $product->image }}" class="order-product-photo" alt="">
                                </a>
                                
                                <div class="order-product-info">
                                    <a href="{{ route('product', $product->slug, false) }}" class="main-text color-text order-product-title">{{ $product->title }}</a>

                                    {{-- <div class="order-product-description">    
                                        <div class="color-text order-product-description-item">Артикул: Т115</div>
                                        <div class="color-text order-product-description-item">Тип: ПМ 30x2,5x8,5</div>
                                    </div> --}}
                                </div>
                                
                                <div class="order-product-right">

                                    <div class="main-text color-text order-count">{{ $product->count }} {{ $fields['count_currency'] }}</div>
                        
                                    <div class="color-text order-product-price">{{ $product->price }} {{ $fields['currency'] }}</div>
                                </div>
                                
                            </div>
                        @endforeach
                    </div>

                    <div class="order-product-info">
                        <div class="extra-text color-text order-product-info-item">{{ $fields['delivery_title'] }}: {{ $order->delivery->title }}</div>
                        <div class="extra-text color-text order-product-info-item">{{ $fields['payment_title'] }}: {{ $order->payment->title }}</div>
                        <div class="extra-text color-text order-product-info-item">{{ $fields['address_title'] }}: {{ $order->city.', '.$order->region }}</div>
                        <div class="extra-text color-text order-product-info-item">{{ $fields['phone_title'] }}: {{ $order->user_phone }}</div>
                    </div>

                </div>
            @endforeach
        @else
            <div class="h4 color-text">{{ $fields['empty'] }}</div>
        @endif
    </div>


</div>

@desktopcss
<style>
    
    .user-history {
        width: 820px;
    }

    .user-order {
        border-bottom: 1px solid var(--color-back-and-stroke);
        padding: 20px 0;
    }

    .user-order:last-child{
        border: none;
    }

    .order-product {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .order-product-title {
        width: 280px;
    }

    .order-products-wrapper {
        padding-top: 20px;
    }


    .order-product-photo-wrapper {
        margin-right: 20px; 
        flex-shrink: 0;
    }

    .order-product-photo {
        width: 100px;
        height: 100px;
        object-fit: contain;
    }

    .order-product-info {
        width: 410px;
    }

    .order-product-description-item {
        font-style: normal;
        font-weight: normal;
        font-size: 12px;
        line-height: 22px;
    }

    .order-product-description {
        margin-top: 5px;
    }

    .order-product-right {
        display: flex;
        align-items: center;
    }

    .order-count {
        margin-right: 70px;
    }

    .order-product-price, .order-sum {
        font-style: normal;
        font-weight: 500;
        font-size: 16px;
        line-height: 26px;
    }

    .user-order-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .user-order-header-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .order-title {
        font-weight: 500;
    }

    .order-status.success {
        color: #05B417;
    }

    .order-status.error {
        color: var(--color-red);
    }

    .order-status.new {
        color: #ddb400;
    }


    .order-product-info-item {
        margin-bottom: 4px;
    }

    .order-product-info-item:last-child {
        margin-bottom: 0;
    }


</style>
@mobilecss
<style>
    
    .user-order {
        border-bottom: 1px solid var(--color-back-and-stroke);
        padding: 20px 0;
    }

    .user-order:last-child{
        border: none;
    }

    .order-product {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 15px;
    }

    .order-product-title {
        width: 164px;
    }

    .order-products-wrapper {
        padding-top: 15px;
    }


    .order-product-photo-wrapper {
        margin-right: 10px; 
        flex-shrink: 0;
    }

    .order-product-photo {
        width: 50px;
        height: 50px;
        object-fit: contain;
    }

    .order-product-description-item {
        font-style: normal;
        font-weight: normal;
        font-size: 12px;
        line-height: 22px;
    }

    .order-product-description {
        margin-top: 5px;
    }

    .order-product-right {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding-left: 60px;
    }

    .order-count {
        margin: 5px 0;
    }

    .order-product-price, .order-sum {
        font-style: normal;
        font-weight: 500;
        font-size: 16px;
        line-height: 26px;
    }


    .user-order-header-right {
        display: flex;
        align-items: center;
    }

    .order-title-sum {
        margin-right: 4px;
        display: flex;
        align-items: center;
    }

    .order-title-sum:after{
        display: block;
        content: ":";
    }

    .order-title {
        font-weight: 500;
        margin-bottom: 5px;
    }

    .order-status.success {
        color: #05B417;
    }

    .order-status.error {
        color: var(--color-red);
    }

    .order-status.new {
        color: #ddb400;
    }


    .order-product-info-item {
        margin-bottom: 4px;
    }

    .order-product-info-item:last-child {
        margin-bottom: 0;
    }


</style>
@endcss