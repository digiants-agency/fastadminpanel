<div class="counter">
    @if (!empty($title))
        <div class="h5 color-text counter-title">{{ $title }}:</div>
    @endif
    <div class="counter-inner">
        <div class="main-text color-second counter-symbol counter-minus" onclick="{{ $minusAction }}">-</div>
        <input class="main-text color-text counter-input" 
            data-currency="{{ $currency }}" 
            type="text" 
            min="{{ $min }}" 
            max="{{ $max }}" 
            step="{{ $step }}" 
            value="{{ $value }}" 
            @if ($readonly)
                readonly
            @endif
            onchange="counter_change(this)"
            onfocus="counter_focus(this)"
        >
        <div class="main-text color-second counter-symbol counter-plus" onclick="{{ $plusAction }}">+</div>
    </div>
</div>


@desktopcss
<style>
    
    .counter {
        margin-bottom: 30px;
    }

    .counter-title {
        margin-bottom: 5px;
    }

    .counter-inner {
        position: relative;
        width: 150px;
    }

    .counter-input {
        background: var(--color-white);
        border: 1px solid var(--color-back-and-stroke);
        border-radius: 6px;
        width: 150px;
        height: 40px;
        text-align: center;
        cursor: pointer;
    }

    .counter-symbol {
        position: absolute;
        top: 0;
        left: 0;
        cursor: pointer;
        transition: .5s;
        display: flex;
        width: 40px;
        height: 40px;
        align-items: center;
        justify-content: center;
        user-select: none;
    }

    .counter-plus {
        left: auto;
        right: 0;
    }

</style>
@mobilecss
<style>
    
    .counter {
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }

    .counter-title {
        margin-right: 10px;
    }

    .counter-inner {
        position: relative;
        width: 115px;
    }

    .counter-input {
        background: var(--color-white);
        border: 1px solid var(--color-back-and-stroke);
        border-radius: 6px;
        width: 115px;
        height: 32px;
        text-align: center;
        cursor: pointer;
    }

    .counter-symbol {
        position: absolute;
        top: 0;
        left: 0;
        cursor: pointer;
        transition: .5s;
        display: flex;
        width: 32px;
        height: 32px;
        align-items: center;
        justify-content: center;
        user-select: none;
    }

    .counter-plus {
        left: auto;
        right: 0;
    }

</style>
@endcss

@startjs
<script>

    $('.counter-symbol').on('click', function(){
        

        counter_input = $(this).el[0].closest('.counter-inner').querySelector('.counter-input')
        step = parseInt($(counter_input).attr('step'))
        currency = $(counter_input).data('currency')
        
        min = parseInt($(counter_input).attr('min'))
        max = parseInt($(counter_input).attr('max'))

        if ($(this).el[0].classList.contains('counter-minus')){

            if (parseInt($(counter_input).val()) > min) {
                $(counter_input).val((parseInt($(counter_input).val()) - step + ' ' + currency).trim())
            }

        } else {

            if (parseInt($(counter_input).val()) < max ) {
                $(counter_input).val((parseInt($(counter_input).val()) + step + ' ' + currency).trim())
            }

        }

    })


    $('.product-info .counter-symbol').on('click', function(){
        
        counter_inputs = $('.product-info .counter-input')
        currency_input = $(counter_input).data('currency')

        price = $('#price').data('price')
        currency = $('#price').text().split(' ').slice(-1)[0].split('/')[0]
        
        new_price = $('#price').text().split(' ')

        counters = 1
        counter_inputs.el.forEach(counter_input => {
            counters *= parseInt($(counter_input).val())
        });

        new_price[1] = price * counters

        // if (counters == 1){
        //     new_price[2] = currency + '/' + currency_input
        // } else {
            new_price[2] = currency
        // }

        $('#price').text(new_price.join(' '))
    })

    function counter_focus(elm){
        $(elm).attr('old-value', $(elm).val());
    }

    function counter_change(elm){
        min = parseInt($(elm).attr('min'))
        max = parseInt($(elm).attr('max'))
        value = $(elm).val()
        oldvalue = $(elm).attr('old-value')
        
        if (!((!isNaN(parseInt(value)) && isFinite(value)) && parseInt(value) >= min && parseInt(value) <= max)) {
            

            if (elm.closest('.cart-product')){
                id_product = $(elm.closest('.cart-product')).data('id')

                Cart.add(id_product, (1 - oldvalue))
            } else {
                $(elm).val(1);
            }
            
        } else {

            if (elm.closest('.cart-product')){
                id_product = $(elm.closest('.cart-product')).data('id')

                Cart.add(id_product, (value - oldvalue))
            }

        }

    }

</script>
@endjs