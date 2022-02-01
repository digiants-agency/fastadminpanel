<div class="modal fade-in" id="modal-forgot">
    <div class="container-modal container-modal-forgot">
        <div class="close closemodal" onclick="close_modal()">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.88393 8.00077L15.8169 1.06771C16.061 0.823615 16.061 0.427865 15.8169 0.183803C15.5729 -0.0602598 15.1771 -0.060291 14.933 0.183803L7.99999 7.11686L1.06697 0.183803C0.822881 -0.060291 0.427132 -0.060291 0.18307 0.183803C-0.0609921 0.427896 -0.0610233 0.823646 0.18307 1.06771L7.11609 8.00074L0.18307 14.9338C-0.0610233 15.1779 -0.0610233 15.5736 0.18307 15.8177C0.305101 15.9397 0.465069 16.0007 0.625038 16.0007C0.785006 16.0007 0.944944 15.9397 1.06701 15.8177L7.99999 8.88467L14.933 15.8177C15.055 15.9397 15.215 16.0007 15.375 16.0007C15.5349 16.0007 15.6949 15.9397 15.8169 15.8177C16.061 15.5736 16.061 15.1779 15.8169 14.9338L8.88393 8.00077Z" fill="#A0A0A0"></path>
            </svg>
        </div>
        <div class="h3 color-text forgot-title">{{ $fields['title'] }}</div>
        
        <form action="" class="forgot-form active" id="send-code" onsubmit="send_code(this, '{{ route('sendcode') }}', '{{ $fields['title'] }}'); return false;">
			
            <div class="extra-text color-text forgot-description">{{ $fields['form_1_description'] }}</div>

            <x-inputs.input name="email" placeholder="{{ $fields['form_1_input'] }}" type="email" required/>
            			
            <x-inputs.button type="submit">
                {{ $fields['form_1_button_text'] }}
            </x-inputs.button>

            <div class="form-answer main-text color-red error">{{ $fields['form_1_error'] }}</div>
        </form>

        <form action="" class="forgot-form" id="check-code" onsubmit="check_code(this, '{{ route('checkcode') }}'); return false;">
			
            <div class="extra-text color-text forgot-description">{{ $fields['form_2_description'] }}</div>

            <x-inputs.input name="code" placeholder="{{ $fields['form_2_input'] }}" type="text" required/>
            			
            <x-inputs.button type="submit">
                {{ $fields['form_2_button_text'] }}
            </x-inputs.button>

            <div class="form-answer main-text color-red error">{{ $fields['form_2_error'] }}</div>
        </form>

        <form action="" class="forgot-form" id="change-password" onsubmit="change_password(this, '{{ route('changepassword') }}'); return false;">
			
            <x-inputs.input name="password" placeholder="{{ $fields['form_3_input_1'] }}" type="password" required/>
            <x-inputs.input name="password_confirmation" placeholder="{{ $fields['form_3_input_2'] }}" type="password" required/>
            			
            <x-inputs.button type="submit">
                {{ $fields['form_3_button_text'] }}
            </x-inputs.button>

            <div class="form-answer main-text color-red error">{{ $fields['form_3_error'] }}</div>
        </form>


        <div class="forgot-buttons">
            <div class="extra-text color-second button-register" onclick="open_login_modal()">{{ $fields['login_text'] }}</div>
            <div class="extra-text color-second button-register" onclick="open_register_modal()">{{ $fields['register_text'] }}</div>
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

    .container-modal-forgot {
        width: 460px;
        padding: 30px 55px;
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

    .modal-title {
        font-style: normal;
        font-weight: 450;
        font-size: 40px;
        line-height: 48px;
        text-align: center;
        margin-bottom: 5px;
    }

    .modal-desc {
        text-align: center;
        margin-bottom: 20px;
    }

    .modal .input {
        margin-bottom: 10px;
    }

    .modal .textarea {
        margin-bottom: 20px;
    }

    .form-answer {
        margin-top: 5px;
    }

    .forgot-title {
        margin-bottom: 20px;
        text-align: center;
    }

    .forgot-buttons {
        margin-top: 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .button-register {
        text-decoration: underline;
        cursor: pointer;
    }

    .button-forgot {
        cursor: pointer;
    }

    .forgot-description {
        margin-bottom: 15px;
        text-align: center;
        white-space: pre-line;
    }

    .forgot-form {
        display: none;
    }

    .forgot-form.active {
        display: block;
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

    .forgot-title {
        margin-bottom: 20px;
        text-align: center;
    }

    .forgot-buttons {
        margin-top: 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .button-register {
        text-decoration: underline;
        cursor: pointer;
    }

    .button-forgot {
        cursor: pointer;
    }

    .forgot-description {
        margin-bottom: 15px;
        text-align: center;
        white-space: pre-line;
    }

    .forgot-form {
        display: none;
    }

    .forgot-form.active {
        display: block;
    }

</style>
@endcss

@js
<script>

    function open_forgot_modal(){

        close_modal()

        modal = '#modal-forgot'

        $(modal).addClass('active')

        scroll_top = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
        $($(modal).el[0].querySelector('.container-modal')).css('top', 'calc(' + scroll_top + 'px + 10vh)');
    }

    async function send_code (form, route, title){
        
        email = $(form.querySelector('input[name="email"]')).val()
        
        const response = await post(route, {
            email: email,
            title: title,
        }, true, true)

        if (response.success){
            $(form.querySelector('.form-answer.error')).css('display', 'none')
            $(form).removeClass('active')
            $('#check-code').addClass('active')

        } else {
            $(form.querySelector('.form-answer.error')).css('display', 'block')
        }

        return false;

    }

    async function check_code (form, route){
        
        email = $($('#send-code').el[0].querySelector('input[name="email"]')).val()
        
        code = $(form.querySelector('input[name="code"]')).val()


        const response = await post(route, {
            email: email,
            code: code,
        }, true, true)

        if (response.success){
            $(form.querySelector('.form-answer.error')).css('display', 'none')
            $(form).removeClass('active')
            $('#change-password').addClass('active')

        } else {
            $(form.querySelector('.form-answer.error')).css('display', 'block')
        }

        return false;

    }

    async function change_password (form, route){
        
        email = $($('#send-code').el[0].querySelector('input[name="email"]')).val()
        code = $($('#check-code').el[0].querySelector('input[name="code"]')).val()
        password = $(form.querySelector('input[name="password"]')).val()
        password_confirmation = $(form.querySelector('input[name="password_confirmation"]')).val()

        const response = await post(route, {
            email: email,
            code: code,
            password: password,
            password_confirmation: password_confirmation,
        }, true, true)

        if (response.success){
            $(form.querySelector('.form-answer.error')).css('display', 'none')
            $(form).removeClass('active')
            $('#send-code').addClass('active')

            close_modal()
            open_login_modal()
            
        } else {

            $(form.querySelector('.form-answer.error')).css('display', 'block')

            if (response.data.password){
                $(form.querySelector('.form-answer.error')).text(response.data.password[0])
            } else if (response.data.phone) {
                $(form.querySelector('.form-answer.error')).text(response.data.phone[0])
            } else if (response.data.email) {
                $(form.querySelector('.form-answer.error')).text(response.data.email[0])
            } else if (response.data.password_confirmation) {
                $(form.querySelector('.form-answer.error')).text(response.data.password_confirmation[0])
            } 

        }

        return false;

    }

</script>
@endjs