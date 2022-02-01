<div class="slider-wrapper">
    

    <div class="product-slider-block">
        <div class="slider">
            @foreach ($images as $image)
                <div><img srcset="/images/lazy.svg" src="{{ $image }}" class="slider-image" alt=""></div>
            @endforeach
        </div>
    </div>

    <div class="product-nav-slider-block">
        <div class="navslider">
            @foreach ($images as $image)
                <div><img srcset="/images/lazy.svg" src="{{ $image }}" class="navslider-image" alt="">  </div>
            @endforeach
        </div>
        <div class="arrows">
            <div class="arrow arrow-prev">
                <svg class="arrow-svg" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.82689 9.45117L14.0775 0.226167C14.3806 -0.0759023 14.8713 -0.0753945 15.1738 0.227729C15.4762 0.530814 15.4754 1.02179 15.1723 1.32409L6.47231 10L15.1726 18.6759C15.4757 18.9783 15.4765 19.4689 15.1742 19.7721C15.0225 19.924 14.8238 20 14.6251 20C14.4268 20 14.2289 19.9245 14.0775 19.7736L4.82689 10.5489C4.68091 10.4036 4.599 10.206 4.599 10C4.599 9.7941 4.68114 9.59668 4.82689 9.45117Z" fill="#A0A0A0"/>
                    <clipPath id="clip0_103_2318">
                    <rect width="20" height="20" fill="white" transform="matrix(-1 0 0 1 20 0)"/>
                    </clipPath>
                </svg>
                                     
            </div>
            <div class="arrow arrow-next">
                <svg class="arrow-svg" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.1731 9.45117L5.92252 0.226167C5.61944 -0.0759023 5.12874 -0.0753945 4.82616 0.227729C4.52382 0.530814 4.5246 1.02179 4.82772 1.32409L13.5277 10L4.82741 18.6759C4.52433 18.9783 4.52355 19.4689 4.82585 19.7721C4.97753 19.924 5.17624 20 5.37495 20C5.57315 20 5.77108 19.9245 5.92249 19.7736L15.1731 10.5489C15.3191 10.4036 15.401 10.206 15.401 10C15.401 9.7941 15.3189 9.59668 15.1731 9.45117Z" fill="#A0A0A0"/>
                    <clipPath id="clip0_103_2322">
                    <rect width="20" height="20" fill="white"/>
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

    .product-slider-block{
        width: 450px;
    }
    
    .product-nav-slider-block{
        width: 450px;
        height: 72px;
        position: relative;
        margin-top: 15px;
    }

    .navslider {
        flex-shrink: 0;
        width: 360px;
        margin: 0 auto;
    }

    .navslider .slick-track{
        display: flex;
    }

    .navslider .slick-slide{
        width: auto !important;
    }

    .navslider-image {
        width: 72px !important;
        height: 72px;
        object-fit: cover;
        margin-right: 20px;
    }

    .slick-current .navslider-image {
        border: 1px solid var(--color-second);
    }

    .slider{
        width: 450px;
    }

    .slider-image {
        width: 450px !important;
        height: 450px;
        object-fit: contain;
    }
    
    .arrow-prev, 
    .arrow-next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        transition: .3s;
    }

    .arrow-next {
        left: auto;
        right: 0;
    }

    .arrow-svg {
        width: 20px;
        height: 20px;
    }

    .arrow-svg path {
        fill: var(--color-grey);
        transition: .3s;
    }

    .arrow:hover path{
        fill: var(--color-text);
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
        position: relative;
    }

    .product-slider-block{
        width: 100%;
    }

    .navslider {
        display: none
    }

    .slider{
        width: 100%;
    }

    .slider-image {
        width: 290px !important;
        height: 290px;
        object-fit: contain;
    }
    
    .arrow-prev, 
    .arrow-next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        left: 12px;
        transform: translateY(-50%);
        transition: .3s;
    }

    .arrow {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--color-white);
        border-radius: 50%;
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
        transition: .3s;
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
                dots: false,
                prevArrow: '.product-nav-slider-block .arrow-prev',
                nextArrow: '.product-nav-slider-block .arrow-next',
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
            });
        } else {
            $('.slider').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                fade: false,
                arrows: true,
                dots: false,
                prevArrow: '.product-nav-slider-block .arrow-prev',
                nextArrow: '.product-nav-slider-block .arrow-next',
            });
        }
        

    })(jQuery)


</script>

@endjs