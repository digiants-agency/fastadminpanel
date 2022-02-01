@if ($ismodal)
    <div class="h3 color-text cart-modal-title">{{ $fields['cart_title'] }}</div>
@else
    <div class="h2 color-text cart-modal-title">{{ $fields['cart_title'] }}</div>
@endif

<div class="cart-products @if(!$ismodal) cart-checkout-products @endif">

    @foreach($products as $product)
        <div class="cart-product" data-id="{{ $product->id }}">

            <div class="delete-cart-product" onclick="Cart.add({{$product->id}},{{-$product->count}})"> 
                <svg class="delete-cart-product-svg" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.88393 8.00077L15.8169 1.06771C16.061 0.823615 16.061 0.427865 15.8169 0.183803C15.5729 -0.0602598 15.1771 -0.060291 14.933 0.183803L7.99999 7.11686L1.06697 0.183803C0.822881 -0.060291 0.427132 -0.060291 0.18307 0.183803C-0.0609921 0.427896 -0.0610233 0.823646 0.18307 1.06771L7.11609 8.00074L0.18307 14.9338C-0.0610233 15.1779 -0.0610233 15.5736 0.18307 15.8177C0.305101 15.9397 0.465069 16.0007 0.625038 16.0007C0.785006 16.0007 0.944944 15.9397 1.06701 15.8177L7.99999 8.88467L14.933 15.8177C15.055 15.9397 15.215 16.0007 15.375 16.0007C15.5349 16.0007 15.6949 15.9397 15.8169 15.8177C16.061 15.5736 16.061 15.1779 15.8169 14.9338L8.88393 8.00077Z" fill="#A0A0A0"></path>
                </svg>
            </div>
            
            <a href="{{ route('product', $product->slug, false) }}" class="cart-product-photo-wrapper">
                <img src="{{ $product->image }}" class="cart-product-photo" alt="">
            </a>
            
            <div class="cart-product-info">
                <a href="{{ route('product', $product->slug, false) }}" class="main-text color-text cart-product-title">{{ $product->title }}</a>

                {{-- <div class="cart-product-description">    
                    <div class="color-text cart-product-description-item">Артикул: Т115</div>
                    <div class="color-text cart-product-description-item">Тип: ПМ 30x2,5x8,5</div>
                </div> --}}
            @if(Platform::desktop())
            </div>
            @endif
            
            <div class="cart-product-right">

                
                <x-inputs.counter 
                    min="1" 
                    max="1000" 
                    minus-action="Cart.add({{ $product->id }}, -1)" 
                    plus-action="Cart.add({{ $product->id }}, 1)" 
                    value="{{ $product->count }}"
                />
    
                <div class="h4 color-text cart-product-price">{{ $product->price * $product->count }} {{ $fields['currency'] }}</div>
            </div>

            @if(!Platform::desktop())
            </div>
            @endif
            
        </div>
    @endforeach

</div>

@if (!$ismodal)
    <div class="cart-price-items">
        <div class="cart-price-item">
            <div class="color-text cart-price-item-title">{{ $cartCountProducts }} {{ $fields['sum_count_title'] }}:</div>
            <div class="main-text color-text cart-price-item-value"><span id="checkout-cart-total">{{ $total }}</span> {{ $fields['currency'] }}</div>
        </div>
        <div class="cart-price-item">
            <div class="color-text cart-price-item-title">{{ $fields['delivery_title'] }}:</div>
            <div class="main-text color-text cart-price-item-value"><span id="checkout-delivery">{{ $delivery }}</span> {{ $fields['currency'] }}</div>
        </div>
    </div>

    <div class="cart-price-item">
        <div class="h4 color-second cart-price-all-title">{{ $fields['total_title'] }}:</div>
        <div class="h4 color-text cart-price-all-value"><span id="checkout-total">{{ $total + $delivery }}</span> {{ $fields['currency'] }}</div>
    </div>
@endif

@desktopcss
<style>
    .cart-product {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 0;
        border-bottom: 1px solid var(--color-back-and-stroke);
    }

    .cart-checkout-products .cart-product {
        align-items: flex-start;
    }

    .cart-product:last-child{
        border: none;
    }

    .delete-cart-product {
        margin: auto 0;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .delete-cart-product-svg {
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    .cart-product-photo-wrapper {
        margin-right: 20px; 
        flex-shrink: 0;
    }

    .cart-product-photo {
        width: 100px;
        height: 100px;
        object-fit: contain;
    }

    .cart-product-info {
        width: 410px;
    }

    .cart-product-title {
        width: 280px;
    }

    .cart-product .counter {
        margin: 0;
        margin-right: 120px;
    }

    .cart-product-description-item {
        font-style: normal;
        font-weight: normal;
        font-size: 12px;
        line-height: 22px;
    }

    .cart-product-description {
        margin-top: 5px;
    }

    .cart-product-right {
        display: flex;
        align-items: center;
    }

    .cart-checkout-products .cart-product-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .cart-checkout-products .cart-product-right .counter {
        margin-right: 0;
    }

    .cart-checkout-products .cart-product-price {
        font-style: normal;
        font-weight: 500;
        font-size: 16px;
        line-height: 26px;
        margin-top: 15px;
        text-align: right;
    }

    .cart-product-price {
        width: 100px;
    }

    .cart-price-items {
        padding: 20px 0;
        border-top: 1px solid var(--color-back-and-stroke);
        border-bottom: 1px solid var(--color-back-and-stroke);
        margin-bottom: 20px;
    }

    .cart-price-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 5px;
    }

    .cart-price-item:last-child {
        margin-bottom: 0;
    }

    .cart-price-item-title {
        font-style: normal;
        font-weight: 500;
        font-size: 16px;
        line-height: 28px;
    }


</style>
@mobilecss
<style>

    .cart-product {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        padding: 15px 0;
        border-bottom: 1px solid var(--color-back-and-stroke);
    }

    .cart-checkout-products .cart-product {
        align-items: flex-start;
    }

    .cart-product:last-child{
        border: none;
    }

    .delete-cart-product {
        flex-shrink: 0;
        order: 3;
    }

    .delete-cart-product-svg {
        width: 13px;
        height: 13px;
        cursor: pointer;
    }

    .cart-product-photo-wrapper {
        margin-right: 10px; 
        flex-shrink: 0;
        order: 1;
    }

    .cart-product-photo {
        width: 50px;
        height: 50px;
        object-fit: contain;
    }

    .cart-product-info {
        width: 164px;
        order: 2;
    }

    .cart-product-title {
        width: 164px;
        font-style: normal;
        font-weight: 500;
        font-size: 12px;
        line-height: 16px;
    }

    .cart-product .counter {
        margin: 0;
    }

    .cart-product-description-item {
        font-style: normal;
        font-weight: normal;
        font-size: 12px;
        line-height: 22px;
    }

    .cart-product-description {
        margin-top: 5px;
    }

    .cart-product-right {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        order: 4;
        margin-top: 10px;
    }

    .cart-product-price {
        font-style: normal;
        font-weight: 500;
        font-size: 13px;
        line-height: 20px;
        margin-top: 7px;
    }

    .cart-checkout-products .cart-product-right .counter {
        margin-right: 0;
    }

    .cart-checkout-products .cart-product-price {
        font-style: normal;
        font-weight: 500;
        font-size: 13px;
        line-height: 20px;
        margin-top: 7px;
        text-align: right;
    }

    .cart-price-items {
        padding: 17px 0;
        border-top: 1px solid var(--color-back-and-stroke);
        border-bottom: 1px solid var(--color-back-and-stroke);
        margin-bottom: 15px;
    }

    .cart-price-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 5px;
    }

    .cart-price-item:last-child {
        margin-bottom: 0;
    }

    .cart-price-item-title {
        font-style: normal;
        font-weight: 500;
        font-size: 14px;
        line-height: 20px;
    }

    .cart-price-item-value {
        font-style: normal;
        font-weight: normal;
        font-size: 14px;
        line-height: 24px;
    }

    .cart-price {
        font-style: normal;
        font-weight: 500;
        font-size: 16px;
        line-height: 24px;
        margin-bottom: 10px;
        text-align: right;
    }

    .cart-price-all-value {
        font-style: normal;
        font-weight: 500;
        font-size: 16px;
        line-height: 24px;
    }

    .cart-btns {
        display: flex;
        flex-direction: column-reverse;
    }

    .cart-btns-right {
        margin-bottom: 10px;
    }

</style>
@endcss

