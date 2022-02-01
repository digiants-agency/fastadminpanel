<div class="horizontal-payment mb-100">
    <div class="container">
        <div class="horizontal-payment-inner">
            
            <img srcset="/images/lazy.svg" src="{{ $fields['image'] }}" alt="" class="horizontal-payment-image desktop">
            <img srcset="/images/lazy.svg" src="{{ $fields['image_mobile'] }}" alt="" class="horizontal-payment-image mobile">

            <div class="horizontal-payment-content">
                <div class="h2 color-text horizontal-payment-title">{{ $fields['title'] }}</div>
                <div class="main-text color-text horizontal-payment-desc">{{ $fields['description'] }}</div>
                <x-inputs.button type="center" size="small" href="{{ Lang::link($fields['button_link']) }}">
                    {{ $fields['button_text'] }}
                </x-inputs.button>  
            </div>
        </div>
    </div>
</div>

@desktopcss

<style>
    
    .horizontal-payment-inner {
        position: relative;
        min-height: 290px;
        border-radius: 6px;
    }

    .horizontal-payment-image {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 6px;
    }

    .horizontal-payment-content {
        position: relative;
        z-index: 1;
        padding: 62px 100px;
        width: 600px;
    }

    .horizontal-payment-title {
        text-align: center;
        margin-bottom: 12px; 
    }

    .horizontal-payment-desc {
        text-align: center;
        margin-bottom: 30px;
    }

    

</style>

@mobilecss

<style>

    .horizontal-payment-inner {
        position: relative;
        min-height: 378px;
        border-radius: 5px;
    }

    .horizontal-payment-image {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 5px;
    }

    .horizontal-payment-content {
        position: relative;
        z-index: 1;
        padding: 20px;
    }

    .horizontal-payment-title {
        text-align: center;
        margin-bottom: 8px; 
    }

    .horizontal-payment-desc {
        text-align: center;
        margin-bottom: 15px;
    }

</style>

@endcss
