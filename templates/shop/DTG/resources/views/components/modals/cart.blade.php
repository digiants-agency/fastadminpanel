<div class="modal fade-in" id="modal-cart">
    <div class="container-modal container-modal-cart">
        <div class="close closemodal" onclick="close_modal()">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.88393 8.00077L15.8169 1.06771C16.061 0.823615 16.061 0.427865 15.8169 0.183803C15.5729 -0.0602598 15.1771 -0.060291 14.933 0.183803L7.99999 7.11686L1.06697 0.183803C0.822881 -0.060291 0.427132 -0.060291 0.18307 0.183803C-0.0609921 0.427896 -0.0610233 0.823646 0.18307 1.06771L7.11609 8.00074L0.18307 14.9338C-0.0610233 15.1779 -0.0610233 15.5736 0.18307 15.8177C0.305101 15.9397 0.465069 16.0007 0.625038 16.0007C0.785006 16.0007 0.944944 15.9397 1.06701 15.8177L7.99999 8.88467L14.933 15.8177C15.055 15.9397 15.215 16.0007 15.375 16.0007C15.5349 16.0007 15.6949 15.9397 15.8169 15.8177C16.061 15.5736 16.061 15.1779 15.8169 14.9338L8.88393 8.00077Z" fill="#A0A0A0"></path>
            </svg>
        </div>

        <div id="mini-cart">
            <x-cart.cart ismodal />
        </div>

        <div class="cart-btns">
            <x-inputs.button type="empty" action="close_modal()">
                {{ $fields['to_buy'] }}
            </x-inputs.button>

            <div class="cart-btns-right">

                <div class="h4 color-text cart-price"><span id="mini-cart-price">{{ $total }}</span> {{ $fields['currency'] }}</div>
                
                @if(empty($total))
                    <x-inputs.button id="cart-submit" type="cart" href="{{ route('checkout', '', false) }}" style="display: none;">
                        {{ $fields['submit_text'] }}
                    </x-inputs.button>
                @else
                    <x-inputs.button id="cart-submit" type="cart" href="{{ route('checkout', '', false) }}">
                        {{ $fields['submit_text'] }}
                    </x-inputs.button>
                @endif
            </div>

        </div>
        
    </div>
</div>


@desktopcss
<style>

    .modal {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);;
        align-items: center;
        justify-content: center;
        display: flex;
        z-index: 10000;
    }

    .modal.active {
        height: 100%;
    }

    .container-modal {
        background: var(--color-white);
        display: flex;
        flex-direction: column;
        position: absolute;
        top: 50px;
        left: 50%;
        transform: translateX(-50%);
    }

    .container-modal-cart {
        width: 1044px;
        padding: 35px 50px 40px;
    }

    .modal .close {
        cursor: pointer;
        position: absolute;
        top: 20px;
        right: 20px;
    }

    .modal .close svg {
        width: 14.41px;
        height: 14.41px;
    }

    .cart-btns {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 20px;
    }

    .cart-btns-right {
        display: flex;
        align-items: center;
    }

    .btn-cart {
        width: 350px;
    }

    .cart-price {
        margin-right: 30px;
    }


</style>
@mobilecss
<style>
    .modal {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);;
        align-items: center;
        justify-content: center;
        display: flex;
        z-index: 10000;
    }

    .modal.active {
        height: 100%;
    }

    .container-modal {
        width: 290px;
        background: var(--color-white);
        display: flex;
        padding: 25px 20px;
        flex-direction: column;
        position: absolute;
        top: 50px;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 6px;
    }

    .modal .close {
        cursor: pointer;
        position: absolute;
        top: 18.6px;
        right: 18.6px;
    }

    .modal .close svg {
        width: 12px;
        height: 12px;
    }

    .modal-title {
        font-style: normal;
        font-weight: 450;
        font-size: 22px;
        line-height: 26px;
        text-align: center;
        margin-bottom: 8px;
    }

    .modal-desc {
        text-align: center;
        margin-bottom: 15px;
    }

    .modal .input {
        margin-bottom: 8px;
    }

    .modal .textarea {
        margin-bottom: 10px;
    }

    .form-answer {
        margin-top: 5px;
    }

</style>
@endcss

@js
<script>

    function open_cart_modal(){

        modal = '#modal-cart'

        $(modal).addClass('active')

        scroll_top = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
        $($(modal).el[0].querySelector('.container-modal')).css('top', 'calc(' + scroll_top + 'px + 10vh)');

    }

    function close_modal() {
        $('.modal').removeClass('active');
    }

    $('.modal').on('click', function(e) {
        if (this == (e.target)) {
            close_modal()
        }
    })
    
</script>
@endjs