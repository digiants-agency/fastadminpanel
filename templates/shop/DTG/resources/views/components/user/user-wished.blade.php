<div class="user-content user-wished @if($active) active @endif">

    <div class="user-wished-header">
        <div class="h4 color-second user-wished-title">{{ $fields['title'] }}</div>
        @if(sizeof($saved))
            <div class="color-grey wished-clear" onclick="Saved.clear()">{{ $fields['clear_title'] }}</div>
        @endif
    </div>



    <div class="user-wisheds">
        <div class="wished-products-wrapper">

            @if(sizeof($saved))
                @foreach ($saved as $product)
                    <div class="wished-product">

                        <div onclick="Saved.toggle(this, {{ $product->id }})" class="delete-wished-product"> 
                            <svg class="delete-wished-product-svg" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.88393 8.00077L15.8169 1.06771C16.061 0.823615 16.061 0.427865 15.8169 0.183803C15.5729 -0.0602598 15.1771 -0.060291 14.933 0.183803L7.99999 7.11686L1.06697 0.183803C0.822881 -0.060291 0.427132 -0.060291 0.18307 0.183803C-0.0609921 0.427896 -0.0610233 0.823646 0.18307 1.06771L7.11609 8.00074L0.18307 14.9338C-0.0610233 15.1779 -0.0610233 15.5736 0.18307 15.8177C0.305101 15.9397 0.465069 16.0007 0.625038 16.0007C0.785006 16.0007 0.944944 15.9397 1.06701 15.8177L7.99999 8.88467L14.933 15.8177C15.055 15.9397 15.215 16.0007 15.375 16.0007C15.5349 16.0007 15.6949 15.9397 15.8169 15.8177C16.061 15.5736 16.061 15.1779 15.8169 14.9338L8.88393 8.00077Z" fill="#A0A0A0"></path>
                            </svg>
                        </div>

                        <a href="{{ route('product', $product->slug, false) }}" class="wished-product-photo-wrapper">
                            <img src="{{ $product->image }}" class="wished-product-photo" alt="">
                        </a>
                        
                        <div class="wished-product-info">
                            <a href="{{ route('product', $product->slug, false) }}" class="main-text color-text wished-product-title">{{ $product->title }}</a>

                        </div>
                        
                        <div class="wished-product-right">
                
                            <div class="color-text wished-product-price">{{ $product->price }} {{ $fields['currency'] }}</div>
                        </div>
                        
                    </div>
                @endforeach
            @else
                <div class="h4 color-text">{{ $fields['empty'] }}</div>
            @endif

        </div>
    </div>


</div>

@desktopcss
<style>
    
    .user-wished {
        width: 610px;
    }

    .wished-product {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
        border-bottom: 1px solid var(--color-back-and-stroke);
        padding-bottom: 15px; 
    }

    .wished-product:last-child{
        border-bottom: none;
    }

    .wished-products-wrapper {
        padding-top: 20px;
    }

    .wished-product-photo-wrapper {
        margin-right: 20px; 
        flex-shrink: 0;
    }

    .wished-product-info {
        width: 270px;
    }

    .wished-product-title {
        width: 250px;
    }

    .wished-product-photo {
        width: 100px;
        height: 100px;
        object-fit: contain;
    }

    .wished-product-right {
        display: flex;
        align-items: center;
    }

    .wished-product-price {
        font-style: normal;
        font-weight: 500;
        font-size: 16px;
        line-height: 26px;
    }

    .user-wished-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .user-wished-header-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .wished-title {
        font-weight: 500;
    }

    .delete-wished-product {
        margin: auto 0;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .delete-wished-product-svg {
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    .wished-clear {
        font-style: normal;
        font-weight: normal;
        font-size: 14px;
        line-height: 24px;
        text-decoration-line: underline;
        cursor: pointer;
    }

</style>
@mobilecss
<style>

    .wished-product {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        border-bottom: 1px solid var(--color-back-and-stroke);
        padding-bottom: 15px; 
        flex-wrap: wrap;
    }

    .wished-product:last-child{
        border-bottom: none;
    }

    .wished-products-wrapper {
        padding-top: 20px;
    }

    .wished-product-photo-wrapper {
        flex-shrink: 0;
    }

    .wished-product-info {
        width: 164px;
        order: 2;
    }

    .wished-product-title {
        width: 164px;
    }

    .wished-product-photo {
        width: 50px;
        height: 50px;
        object-fit: contain;
        order: 1;
    }

    .wished-product-right {
        display: flex;
        align-items: center;
        order: 3;
        padding-left: 75px;
    }

    .wished-product-price {
        font-style: normal;
        font-weight: 500;
        font-size: 13px;
        line-height: 20px;
    }

    .user-wished-header {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .user-wished-header-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .wished-title {
        font-weight: 500;
    }

    .delete-wished-product {
        flex-shrink: 0;
        order: 3;
    }

    .delete-wished-product-svg {
        width: 14px;
        height: 14px;
        cursor: pointer;
    }

    .wished-clear {
        font-style: normal;
        font-weight: normal;
        font-size: 14px;
        line-height: 24px;
        text-decoration-line: underline;
        cursor: pointer;
        margin-top: 10px;
    }

</style>
@endcss