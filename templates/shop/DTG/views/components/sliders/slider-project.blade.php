<div class="slider-wrapper">
    
    <div class="product-nav-slider-block">
        <div class="navslider">
            @foreach ($images as $image)
                <img srcset="/images/lazy.svg" src="{{ $image }}" class="navslider-image" alt="">            
            @endforeach
        </div>
    </div>

    <div class="product-slider-block">
        <div class="slider">
            @foreach ($images as $image)
                <img srcset="/images/lazy.svg" src="{{ $image }}" class="slider-image" alt="">            
            @endforeach
        </div>
        <div class="arrows">
            <div class="arrow arrow-prev">
                <svg class="arrow-svg" width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.98481 7.03154L9.88706 1.13125C10.1461 0.872917 10.5657 0.872917 10.8253 1.13125C11.0843 1.38958 11.0843 1.80918 10.8253 2.06752L5.3912 7.49965L10.8246 12.9318C11.0836 13.1901 11.0836 13.6097 10.8246 13.8687C10.5657 14.127 10.1454 14.127 9.88641 13.8687L3.98416 7.96841C3.72909 7.71274 3.72909 7.28655 3.98481 7.03154Z" fill="#A0A0A0"/>
                    <clipPath id="clip0_118_2604">
                    <rect width="13.125" height="13.125" fill="white" transform="matrix(-1 0 0 1 13.9688 0.9375)"/>
                    </clipPath>
                </svg>                    
            </div>
            <div class="arrow arrow-next">
                <svg class="arrow-svg" width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.0152 7.03154L4.11294 1.13125C3.85395 0.872917 3.43435 0.872917 3.17471 1.13125C2.91572 1.38958 2.91572 1.80918 3.17471 2.06752L8.6088 7.49965L3.17536 12.9318C2.91638 13.1901 2.91638 13.6097 3.17536 13.8687C3.43435 14.127 3.8546 14.127 4.11359 13.8687L10.0158 7.96841C10.2709 7.71274 10.2709 7.28655 10.0152 7.03154Z" fill="#231F20"/>
                    <clipPath id="clip0_118_2614">
                    <rect width="13.125" height="13.125" fill="white" transform="translate(0.03125 0.9375)"/>
                    </clipPath>
                </svg>
            </div>                              
        </div>
    </div>

</div>


@desktopcss

<style>
    /* Slider */
    .slick-slider
    {
        position: relative;

        display: block;
        box-sizing: border-box;

        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;

        -webkit-touch-callout: none;
        -khtml-user-select: none;
        -ms-touch-action: pan-y;
        touch-action: pan-y;
        -webkit-tap-highlight-color: transparent;
    }

    .slick-list
    {
        position: relative;
        display: block;
        overflow: hidden;
        margin: 0;
        padding: 0;
    }

    .slick-list:focus
    {
        outline: none;
    }

    .slick-list.dragging
    {
        cursor: pointer;
        cursor: hand;
    }

    .slick-slider .slick-track,
    .slick-slider .slick-list
    {
        -webkit-transform: translate3d(0, 0, 0);
        -moz-transform: translate3d(0, 0, 0);
        -ms-transform: translate3d(0, 0, 0);
        -o-transform: translate3d(0, 0, 0);
        transform: translate3d(0, 0, 0);
    }

    .slick-track
    {
        position: relative;
        top: 0;
        left: 0;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    .slick-track:before,
    .slick-track:after
    {
        display: table;
        content: '';
    }

    .slick-track:after
    {
        clear: both;
    }

    .slick-loading .slick-track
    {
        visibility: hidden;
    }

    .slick-slide
    {
        display: none;
        float: left;
        height: 100%;
        min-height: 1px;
    }

    [dir='rtl'] .slick-slide
    {
        float: right;
    }

    .slick-slide img
    {
        display: block;
    }

    .slick-slide.slick-loading img
    {
        display: none;
    }

    .slick-slide.dragging img
    {
        pointer-events: none;
    }

    .slick-initialized .slick-slide
    {
        display: block;
    }

    .slick-loading .slick-slide
    {
        visibility: hidden;
    }

    .slick-vertical .slick-slide
    {
        display: block;
        height: auto;
        border: 1px solid transparent;
    }

    .slick-arrow.slick-hidden {
        display: none;
    }

</style>


<style>
    
    .slider-wrapper {
        margin-bottom: 40px;
    }

    .slider-wrapper {
        display: flex;
    }

    .navslider {
        flex-shrink: 0;
        margin-right: 30px;
        width: 170px !important;

    }

    .navslider-image {
        width: 170px !important;
        height: 105px;
        margin-bottom: 18.5px;
        object-fit: cover;
    }

    .slick-current .navslider-image {
        border: 1px solid var(--color-second);
    }

    .slider{
        width: 1040px;
    }

    .slider-image {
        width: 1040px !important;
        height: 500px;
        object-fit: contain;
    }

    .slider .slick-dots {
        display: flex;
        list-style: none;
        position: absolute;
        bottom: 25px;
        left: 50%;
        transform: translateX(-50%);
    }

    .slider .slick-dots li {
        flex-shrink: 1;
        margin: 0 5px;
    }

    .slider .slick-dots li button {
        font-size: 0;
        line-height: 0;
        display: block;
        width: 10px;
        height: 10px;
        padding: 0;
        list-style: none;
        background: rgba(35, 31, 32, 0.2);;
        border: none;
        border-radius: 50%;
        cursor: pointer;
    }

    .slider .slick-dots .slick-active button {
        background: var(--color-second);
        position: relative;
    }

    .slider .slick-dots .slick-active button:before {
        position: absolute;
        content: "";
        display: block;
        width: 18px;
        height: 18px;
        border: 1px solid var(--color-second);
        top: 50%;
        left: 50%;
        z-index: 3;
        transform: translate(-50%, -50%);
        border-radius: 50%;
    }

    .product-nav-slider-block{
        height: 500px;
    }
    
    .product-slider-block {
        position: relative;
        height: 500px;
    }
    
    .arrow-prev, 
    .arrow-next {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 35px;
        height: 35px;
        background-color: var(--color-white);
        border-radius: 50%;
        cursor: pointer;
        position: absolute;
        top: 50%;
        left: 40px;
        transform: translateY(-50%);
        transition: .3s;
    }

    .arrow-next {
        left: auto;
        right: 40px;
    }

    .arrow-svg {
        width: 13.12px;
        height: 13.12px;
    }

    .arrow-svg path {
        fill: var(--color-text);
        transition: .3s;
    }

    .arrow:hover {
        background-color: var(--color-second);
    }

    .arrow:hover path{
        fill: var(--color-white);
    }

</style>

@mobilecss
<style>
    /* Slider */
    .slick-slider
    {
        position: relative;

        display: block;
        box-sizing: border-box;

        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;

        -webkit-touch-callout: none;
        -khtml-user-select: none;
        -ms-touch-action: pan-y;
        touch-action: pan-y;
        -webkit-tap-highlight-color: transparent;
    }

    .slick-list
    {
        position: relative;
        display: block;
        overflow: hidden;
        margin: 0;
        padding: 0;
    }

    .slick-list:focus
    {
        outline: none;
    }

    .slick-list.dragging
    {
        cursor: pointer;
        cursor: hand;
    }

    .slick-slider .slick-track,
    .slick-slider .slick-list
    {
        -webkit-transform: translate3d(0, 0, 0);
        -moz-transform: translate3d(0, 0, 0);
        -ms-transform: translate3d(0, 0, 0);
        -o-transform: translate3d(0, 0, 0);
        transform: translate3d(0, 0, 0);
    }

    .slick-track
    {
        position: relative;
        top: 0;
        left: 0;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    .slick-track:before,
    .slick-track:after
    {
        display: table;
        content: '';
    }

    .slick-track:after
    {
        clear: both;
    }

    .slick-loading .slick-track
    {
        visibility: hidden;
    }

    .slick-slide
    {
        display: none;
        float: left;
        height: 100%;
        min-height: 1px;
    }

    [dir='rtl'] .slick-slide
    {
        float: right;
    }

    .slick-slide img
    {
        display: block;
    }

    .slick-slide.slick-loading img
    {
        display: none;
    }

    .slick-slide.dragging img
    {
        pointer-events: none;
    }

    .slick-initialized .slick-slide
    {
        display: block;
    }

    .slick-loading .slick-slide
    {
        visibility: hidden;
    }

    .slick-vertical .slick-slide
    {
        display: block;
        height: auto;
        border: 1px solid transparent;
    }

    .slick-arrow.slick-hidden {
        display: none;
    }

</style>


<style>
    
    .slider-wrapper {
        margin-bottom: 25px;
    }

    .slider-wrapper {
        display: flex;
    }

    .navslider {
        display: none;
    }

    .slider{
        width: 290px;
    }

    .slider-image {
        width: 290px !important;
        height: 290px;
        object-fit: contain;
    }

    .slider .slick-dots {
        display: flex;
        list-style: none;
        position: absolute;
        bottom: 25px;
        left: 50%;
        transform: translateX(-50%);
    }

    .slider .slick-dots li {
        flex-shrink: 1;
        margin: 0 8px;
    }

    .slider .slick-dots li button {
        font-size: 0;
        line-height: 0;
        display: block;
        width: 6px;
        height: 6px;
        padding: 0;
        list-style: none;
        background: rgba(35, 31, 32, 0.2);;
        border: none;
        border-radius: 50%;
        cursor: pointer;
    }

    .slider .slick-dots .slick-active button {
        background: var(--color-second);
        position: relative;
    }

    .slider .slick-dots .slick-active button:before {
        position: absolute;
        content: "";
        display: block;
        width: 16px;
        height: 16px;
        border: 1px solid var(--color-second);
        top: 50%;
        left: 50%;
        z-index: 3;
        transform: translate(-50%, -50%);
        border-radius: 50%;
    }

    .product-nav-slider-block{
        height: 290px;
    }
    
    .product-slider-block {
        position: relative;
        height: 290px;
    }
    
    .arrow-prev, 
    .arrow-next {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        background-color: var(--color-white);
        border-radius: 50%;
        cursor: pointer;
        position: absolute;
        top: 50%;
        left: 12px;
        transform: translateY(-50%);
        transition: .3s;
    }

    .arrow-next {
        left: auto;
        right: 12px;
    }

    .arrow-svg {
        width: 9px;
        height: 9px;
    }

    .arrow-svg path {
        fill: var(--color-text);
    }

</style>
@endcss

<?php JSAssembler::add('/js/slider.js'); ?>

@js

<script>

    (function($){
        
        if (screen.width > 900){

            $('.slider').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                fade: false,
                arrows: true,
                dots: true,
                prevArrow: '.product-slider-block .arrow-prev',
                nextArrow: '.product-slider-block .arrow-next',
                asNavFor: '.navslider',
            });

            $('.navslider').slick({
                infinity: true,
                fade: false,
                slidesToShow: 4,
                slidesToScroll: 1,
                speed: 400,
                arrows: false,
                asNavFor: '.slider',
                // variableWidth: true,
                focusOnSelect: true,
                vertical: true,
                verticalSwiping: true,
            });
        } else {
            $('.slider').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                fade: false,
                arrows: true,
                dots: true,
                prevArrow: '.product-slider-block .arrow-prev',
                nextArrow: '.product-slider-block .arrow-next',
            });
        }

        

    })(jQuery)


</script>

@endjs