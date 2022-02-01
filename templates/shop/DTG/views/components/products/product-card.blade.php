<div class="product-card @if(!$product->is_available) inactive @endif">
    <a href="{{ route('product', $product->slug, false) }}">
        <img src="{{ $product->image }}" alt="" class="product-card-image">
    </a>
    <div class="product-card-content">
        <a href="{{ route('product', $product->slug, false) }}" class="product-card-title color-text">{{ $product->title }}</a>
        <div class="product-card-bottom">
            @if ($product->is_available)
                <div class="product-card-price color-second">{{ $fields['from'] }} {{ $product->price }} {{ $fields['currency'] }}</div>
            @else
                <div class="product-card-price color-second">{{ $fields['not_available'] }}</div>
            @endif
            <div class="product-card-buttons">
                <x-inputs.button type="empty" size="small" href="{{ route('product', $product->slug, false) }}">
                    {{ $fields['button_more'] }}
                </x-input.button>
                {{-- <x-inputs.button type="product" size="small" action="open_modal('callback', '{{ route('product', $product->slug) }}')">
                    {{ $fields['button_order'] }}
                </x-input.button> --}}
                <x-inputs.button type="product" size="small" action="Cart.add({{ $product->id }}, 1)">
                    {{ $fields['button_order'] }}
                </x-input.button>
            </div>
        </div>
    </div>
    
</div>

@desktopcss
<style>

    .product-card {
        width: 290px;
        margin-right: 26px;
        margin-bottom: 40px;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .product-card.inactive {
        pointer-events: none;
        opacity: .3;
    }

    .product-card::before {
        content: "";
        display: block;
        position: absolute;
        width: 320px;
        height: calc(100% + 45px);
        background: transparent;
        top: -15px;
        left: -15px;
        z-index: -1;
        transition: .4s;
    }

    .product-card:hover::before {
        box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.7);
        z-index: 0;
        pointer-events: none;
    }

    .product-card-image{
        width: 290px;
        height: 270px;
        object-fit: contain;
        margin-bottom: 10px;
    }

    .product-card-content{
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }

    .product-card-title {
        font-style: normal;
        font-weight: 450;
        font-size: 20px;
        line-height: 26px;
        margin-bottom: 20px;
    }

    .product-card-price {
        font-style: normal;
        font-weight: 450;
        font-size: 22px;
        line-height: 28px;
        margin-bottom: 20px;
    }

    .product-card-buttons {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

</style>
@mobilecss
<style>

    .product-card {
        width: 136px;
        margin-right: 0;
        margin-bottom: 30px;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .product-card.inactive {
        pointer-events: none;
        opacity: .3;
    }

    .product-card-image{
        width: 100%;
        height: 135px;
        object-fit: contain;
        margin-bottom: 10px;
    }

    .product-card-content{
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }

    .product-card-title {
        font-style: normal;
        font-weight: 450;
        font-size: 16px;
        line-height: 18px;
        margin-bottom: 10px;
    }

    .product-card-price {
        font-style: normal;
        font-weight: 450;
        font-size: 18px;
        line-height: 20px;
        margin-bottom: 15px;
    }

    .product-card-buttons {
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: space-between;
        height: 85px;
        width: 100%;
    }

    .product-card .btn{
        width: 100%;
    }

</style>
@endcss
