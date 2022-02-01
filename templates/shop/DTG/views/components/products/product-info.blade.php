<div class="product-info">
    <h1 class="h2 color-text product-title">{{ $product->title }}</h1>
    <div class="main-text color-text product-desc">{!! $product->short_description !!}</div>
    <div class="color-second product-price" 
        id="price" 
        data-price="{{ $product->price }}"
    >
        {{ $fields['from'] }} {{ $product->price }} {{ $fields['currency'] }}
    </div>

    @if($product->is_available)
        <div class="extra-text color-second product-available">{{ $fields['available'] }}</div>
    @else
        <div class="extra-text color-red product-available">{{ $fields['not_available'] }}</div> 
    @endif
    
    @foreach ($product->attributes_counter as $item)
        <x-inputs.counter 
            title="{{ $item->title }}" 
            min="{{ $item->min }}" 
            max="{{ $item->max }}" 
            value="1" 
            step="{{ $item->step }}" 
            currency="{{ $item->currency }}" 
            readonly 
        />
    @endforeach

    <div class="product-info-btns">
        @if($product->is_available)
            <x-inputs.button action="add_product({{ $product->id }})">
                {{ $fields['button_text'] }}
            </x-inputs.button>
            {{-- <x-inputs.button action="open_modal('callback' , '{{ url()->current() }}', true)">
                {{ $fields['button_text'] }}
            </x-inputs.button> --}}
        @endif

        <svg class="btn-saved @if($product->saved) active @endif" onclick="Saved.toggle(this, {{ $product->id }})" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path class="btn-saved-fill" d="M9.49985 2.99999C9.89985 2.99999 12.6665 5.33333 13.9998 6.49999L15.0001 6L16.5001 4L19.0001 2.99999H22.0001C23.0001 2.99999 23.5001 4 25.0001 4.5C26.5001 5 26.0001 8 27.0001 9C27.8001 9.8 26.3334 13.6667 25.5001 15L21.0001 19L14.5001 25H13.0001L9.49985 21.5C8.33325 20.3333 5.90007 18 5.50007 18C5.00007 18 2.49967 15 1.49967 12C0.499671 9 2.00015 6.5 3 5C3.83196 3.75187 5.49985 3.49999 5.99985 2.99999C6.49985 2.49999 8.99985 2.99999 9.49985 2.99999Z" fill="#26C6DA"/>
            <path class="btn-saved-border" d="M14 26.4423C13.6014 26.4423 13.217 26.2979 12.9175 26.0355C11.7864 25.0464 10.6959 24.117 9.73372 23.2971L9.7288 23.2928C6.90792 20.8889 4.47198 18.8129 2.77709 16.7679C0.882475 14.4817 0 12.3141 0 9.94608C0 7.64536 0.788908 5.5228 2.22125 3.96912C3.67068 2.39706 5.6595 1.53125 7.82201 1.53125C9.43828 1.53125 10.9185 2.04224 12.2214 3.0499C12.8789 3.55853 13.4749 4.18103 14 4.90714C14.5253 4.18103 15.1211 3.55853 15.7788 3.0499C17.0817 2.04224 18.5619 1.53125 20.1782 1.53125C22.3404 1.53125 24.3295 2.39706 25.7789 3.96912C27.2113 5.5228 27.9999 7.64536 27.9999 9.94608C27.9999 12.3141 27.1177 14.4817 25.2231 16.7677C23.5282 18.8129 21.0925 20.8887 18.272 23.2924C17.3081 24.1136 16.2159 25.0445 15.0822 26.0359C14.7829 26.2979 14.3984 26.4423 14 26.4423ZM7.82201 3.17145C6.12307 3.17145 4.56234 3.84949 3.42693 5.08081C2.27465 6.33072 1.63998 8.0585 1.63998 9.94608C1.63998 11.9377 2.38018 13.7189 4.03982 15.7214C5.64391 17.657 8.02986 19.6903 10.7924 22.0446L10.7976 22.0489C11.7633 22.872 12.8582 23.8051 13.9976 24.8014C15.1439 23.8032 16.2404 22.8686 17.2082 22.0442C19.9705 19.6898 22.3563 17.657 23.9603 15.7214C25.6198 13.7189 26.36 11.9377 26.36 9.94608C26.36 8.0585 25.7253 6.33072 24.573 5.08081C23.4378 3.84949 21.8769 3.17145 20.1782 3.17145C18.9336 3.17145 17.7909 3.56708 16.782 4.34723C15.8828 5.04279 15.2565 5.92206 14.8893 6.53729C14.7004 6.85367 14.368 7.04251 14 7.04251C13.6319 7.04251 13.2995 6.85367 13.1107 6.53729C12.7437 5.92206 12.1173 5.04279 11.218 4.34723C10.209 3.56708 9.06636 3.17145 7.82201 3.17145Z" fill="#26C6DA"/>
        </svg>

    </div>
    
        
</div>


@desktopcss
<style>

    .product-info {
        margin-left: 100px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .product-info-btns {
        display: flex;
        align-items: center;
    }

    .btn-saved {
        width: 28px;
        height: 28px;
        margin-left: 30px;
        cursor: pointer;
    }

    .btn-saved-border {
        fill: var(--color-second);
    }

    .btn-saved-fill {
        fill: transparent;
        transition: .3s;
    }

    .btn-saved.active .btn-saved-fill{
        fill: var(--color-second);
    }
    
    .product-title {
        margin-bottom: 15px;
    }

    .product-desc {
        margin-bottom: 20px;
    }

    .product-price {
        font-style: normal;
        font-weight: 500;
        font-size: 26px;
        line-height: 26px;
        margin-bottom: 5px;
    }

    .product-available {
        margin-bottom: 25px;
    }

</style>
@mobilecss
<style>

    .product-info {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-top: 10px;
    }

    .product-info-btns {
        display: flex;
        align-items: center;
    }

    .btn-saved {
        width: 28px;
        height: 28px;
        margin-left: 30px;
        cursor: pointer;
    }

    .btn-saved-border {
        fill: var(--color-second);
    }

    .btn-saved-fill {
        fill: transparent;
        transition: .3s;
    }

    .btn-saved.active .btn-saved-fill{
        fill: var(--color-second);
    }
    
    .product-title {
        margin-bottom: 15px;
    }

    .product-desc {
        margin-bottom: 10px;
    }

    .product-price {
        font-style: normal;
        font-weight: 450;
        font-size: 18px;
        line-height: 20px;
    }

    .product-available {
        margin-bottom: 20px;
    }

    .product-info .btn {
        width: 140px;
    }

</style>
@endcss

@js
<script>

    function add_product(id_product){
        
        count = 1

        if ($('.product-info .counter-input').el[0])
            count = parseInt($('.product-info .counter-input').val())
        

        Cart.add(id_product, count)
    }

</script>
@endjs