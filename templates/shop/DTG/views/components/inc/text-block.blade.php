<div class="textblock mb-100">
    <div class="container">
        <div {{ $attributes->merge([ 'class' => 'text-block-inner text-block-inner-'.$type ]) }}>

            <div {{ $attributes->merge([ 'class' => 'text-block-content text-block-content-'.$type ]) }}>
                {{ $content }}
    
                @if(isset($button))
                    {{ $button }}
                @endif
            </div>

            <img srcset="/images/lazy.svg" src="{{ $image }}" alt="" class="text-block-image">
        </div>
    </div>
</div>

@desktopcss

<style>
    
    .text-block-inner {
        display: flex;
        justify-content: space-between;
    }

    .text-block-inner .btn {
        margin-top: 25px;
    }

    
    .text-block-inner .text-block-image {
        width: 612px;
        height: 662px;
    }

    .text-block-inner-about .text-block-image {
        width: 537px;
        height: 482px;
    }

    .text-block-content{
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .text-block-inner .text-block-content{
        width: 470px;
    }

    .text-block-inner-about .text-block-content{
        width: 565px;
    }
    
</style>

@mobilecss

<style>
    
    .text-block-inner .btn {
        margin-top: 25px;
        width: 180px;
    }
    
    .text-block-inner .text-block-image {
        width: 100vw;
        max-width: 100vh;
        margin-left: calc( -1 * (100vw - 100%) / 2);
        margin-top: 25px;
    }

    .text-block-inner-about .text-block-image {
        width: 100%;
        margin: 0;
        margin-top: 20px;
    }

    .text-block-content {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

</style>

@endcss
