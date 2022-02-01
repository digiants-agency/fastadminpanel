<div class="error-404 mb-100">
    <div class="container">
        <div class="error-404-inner">
            <img srcset="/images/lazy.svg" src="{{ $fields['image'] }}" alt="" class="error-404-image">
            <div class="h2 color-text error-404-title">{{ $fields['text'] }}</div>
            <x-inputs.button href="{{ Lang::link($fields['button_link']) }}" type="center">
                {{ $fields['button_text'] }}
            </x-inputs.button>
        </div>
    </div>
</div>

@desktopcss

<style>
    
    .error-404-inner {
        display: flex;
        align-items: center;
        flex-direction: column;
        padding-top: 20px;
    }

    .error-404-image{
        width: 564px;
        height: 315px;
        object-fit: cover
    }

    .error-404-title{
        margin: 40px 0 30px;
    }


</style>

@mobilecss

@endcss
