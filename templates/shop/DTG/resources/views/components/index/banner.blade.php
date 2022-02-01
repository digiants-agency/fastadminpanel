<div class="mainbanner mb-100">
    
    <img class="mainbanner-image desktop" src="{{ $fields['image'] }}" alt="">
    <img class="mainbanner-image mobile" src="{{ $fields['image_mobile'] }}" alt="">

    
    <div class="container">
        <div class="mainbanner-inner">
            <div class="h1 mainbanner-title">{{ $fields['title'] }}</div>
            <div class="h5 mainbanner-desc">{{ $fields['description'] }}</div>
            <x-inputs.button action="open_modal('callback')">
                {{ $fields['button_text'] }}
            </x-inputs.button>
        </div>
    </div>
</div>


@desktopcss
<style>

    .mainbanner {
        position: relative;
        width: 100%;
        height: 558px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
    }

    .mainbanner-image {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .mainbanner-inner {
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .mainbanner-title, 
    .mainbanner-desc {
        color: var(--color-white);
        white-space: pre;
    }

    .mainbanner-title {
        margin-bottom: 20px;
    }

    .mainbanner-desc { 
        margin-bottom: 50px;
    }

        
</style>
@mobilecss
<style>

    .mainbanner {
        position: relative;
        width: 100%;
        height: 470px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
    }

    .mainbanner-image {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .mainbanner-inner {
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .mainbanner-title, 
    .mainbanner-desc {
        color: var(--color-white);
    }

    .mainbanner-title {
        margin-bottom: 15px;
    }

    .mainbanner-desc { 
        margin-bottom: 25px;
    }

</style>
@endcss