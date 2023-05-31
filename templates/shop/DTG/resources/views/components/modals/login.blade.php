<div class="modal fade-in" id="modal-login">
    <div class="container-modal container-modal-login">
        <div class="close closemodal" onclick="close_modal()">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.88393 8.00077L15.8169 1.06771C16.061 0.823615 16.061 0.427865 15.8169 0.183803C15.5729 -0.0602598 15.1771 -0.060291 14.933 0.183803L7.99999 7.11686L1.06697 0.183803C0.822881 -0.060291 0.427132 -0.060291 0.18307 0.183803C-0.0609921 0.427896 -0.0610233 0.823646 0.18307 1.06771L7.11609 8.00074L0.18307 14.9338C-0.0610233 15.1779 -0.0610233 15.5736 0.18307 15.8177C0.305101 15.9397 0.465069 16.0007 0.625038 16.0007C0.785006 16.0007 0.944944 15.9397 1.06701 15.8177L7.99999 8.88467L14.933 15.8177C15.055 15.9397 15.215 16.0007 15.375 16.0007C15.5349 16.0007 15.6949 15.9397 15.8169 15.8177C16.061 15.5736 16.061 15.1779 15.8169 14.9338L8.88393 8.00077Z" fill="#A0A0A0"></path>
            </svg>
        </div>
        <div class="h3 color-text login-title">{{ $fields['title'] }}</div>
        <form action="" class="login-form" onsubmit="user_login(this, '{{ route('login', '', false) }}'); return false;">
			
            <x-inputs.input name="email" placeholder="{{ $fields['input_1'] }}" type="email" required/>
            <x-inputs.input name="password" placeholder="{{ $fields['input_2'] }}" type="password" required/>
            			
            <x-inputs.checkbox name="privacy" required>
                {{ $fields['privacy'] }}
            </x-inputs.checkbox>

            <x-inputs.button type="submit">
                {{ $fields['button_text'] }}
            </x-inputs.button>

            <div class="form-answer main-text color-red error">{{ $fields['error'] }}</div>
        </form>
        <div class="login-buttons">
            <div class="extra-text color-grey button-forgot" onclick="open_forgot_modal()">{{ $fields['forgot_text'] }}</div>
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

    .container-modal-login {
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

    .login-form .containercheckbox {
		margin-bottom: 16px;
		padding-left: 34px;
	}

	.login-form .containercheckbox .checkmark {
		right: auto;
		left: 0;
	}

	.login-form .containercheckbox p {
		display: inline;
	}

	.login-form .containercheckbox p a {
		display: inline;
		color: var(--color-second);
		text-decoration: underline;
	}

    .login-title {
        margin-bottom: 20px;
        text-align: center;
    }

    .login-buttons {
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
        height: 40px;
    }

    .modal .textarea {
        margin-bottom: 10px;
    }

    .form-answer {
        margin-top: 5px;
    }

    .login-form .containercheckbox {
		margin-bottom: 16px;
		padding-left: 28px;

        font-style: normal;
        font-weight: normal;
        font-size: 12px;
        line-height: 20px;
	}

	.login-form .containercheckbox .checkmark {
		right: auto;
		left: 0;
        width: 18px;
        height: 18px;
	}

	.login-form .containercheckbox p {
		display: inline;
	}

	.login-form .containercheckbox p a {
		display: inline;
		color: var(--color-second);
		text-decoration: underline;

	}

    .login-title {
        margin-bottom: 15px;
        text-align: center;
    }

    .login-buttons {
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


</style>
@endcss

@startjs
<script>

    function open_login_modal(){

        close_modal()

        modal = '#modal-login'

        $(modal).addClass('active')

        scroll_top = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
        $($(modal).el[0].querySelector('.container-modal')).css('top', 'calc(' + scroll_top + 'px + 10vh)');
    }


    async function user_login(form, route){
        
        email = $(form.querySelector('input[name="email"]')).val()
        password = $(form.querySelector('input[name="password"]')).val()

        
        const response = await post(route, {
            email: email,
            password: password,
        }, true, true)

        if (response.success){

            location.href = response.data.redirect
        
        } else {
            $(form.querySelector('.form-answer.error')).css('display', 'block')
        }

        return false;
    } 

</script>
@endjs