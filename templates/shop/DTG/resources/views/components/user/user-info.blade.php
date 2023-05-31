<div class="user-content user-info @if($active) active @endif">
    <div class="h4 color-second user-info-title">{{ $fields['title'] }}</div>


    <form class="user-info-form" onsubmit="edit_user(this, '{{ route('edit-user', '', false) }}'); return false;">

        <label for="name" class="color-text extra-text user-info-input-label">{{ $fields['label_1'] }}</label>
        <x-inputs.input name="name" type="text" placeholder="{{ $fields['input_1'] }}" value="{{ $user->name ?? '' }}" />
    
        <label for="surname" class="color-text extra-text user-info-input-label">{{ $fields['label_2'] }}</label>
        <x-inputs.input name="surname" type="text" placeholder="{{ $fields['input_2'] }}" value="{{ $user->surname ?? '' }}" />
    
        <label for="login" class="color-text extra-text user-info-input-label">{{ $fields['label_3'] }}</label>
        <x-inputs.input name="login" type="text" placeholder="{{ $fields['input_3'] }}" value="{{ $user->login ?? '' }}" />
        <div class="extra-text color-grey user-info-remark">{{ $fields['remark_3'] }}</div>
    
        <label for="email" class="color-text extra-text user-info-input-label">{{ $fields['label_4'] }}</label>
        <x-inputs.input name="email" type="email" placeholder="{{ $fields['input_4'] }}" value="{{ $user->email ?? '' }}" />
    
        <label for="phone" class="color-text extra-text user-info-input-label">{{ $fields['label_5'] }}</label>
        <x-inputs.input name="phone" type="tel" placeholder="{{ $fields['input_5'] }}" value="{{ $user->phone ?? '' }}" pattern="^[+ 0-9]+$" title="+380681234567" />
    
        <label for="password" class="color-text extra-text user-info-input-label">{{ $fields['label_6'] }}</label>
        <x-inputs.input name="password" type="password" placeholder="{{ $fields['input_6'] }}" />
        <div class="extra-text color-grey user-info-remark">{{ $fields['remark_6'] }}</div>
    
        <label for="password_confirmation" class="color-text extra-text user-info-input-label">{{ $fields['label_7'] }}</label>
        <x-inputs.input name="password_confirmation" type="password" placeholder="{{ $fields['input_7'] }}" />
    
    
        <x-inputs.button type="submit" >
            {{ $fields['button_text'] }}
        </x-inputs.button>

        <div class="extra-text color-green message success">
            {{ $fields['message_1'] }}
        </div>

        <div class="extra-text color-red message error">
            {{ $fields['message_2'] }}
        </div>

    </form>

</div>

@desktopcss
<style>
    
    .user-info {
        width: 480px;
    }

    .user-info-input-label {
        display: block;
        margin-bottom: 5px;
        margin-top: 12px;
    }

    .user-info-remark {
        margin-top: 5px;
    }

    .user-info .btn {
        width: 220px;
        margin-top: 20px;
    }

    .message {
        margin-top: 15px;
        display: none;
    }


</style>
@mobilecss
<style>

    .user-info-input-label {
        display: block;
        margin-bottom: 5px;
        margin-top: 12px;
    }

    .user-info-remark {
        margin-top: 5px;
    }

    .user-info .btn {
        width: 180px;
        margin-top: 25px;
    }

    .message {
        margin-top: 10px;
        display: none;
    }

</style>
@endcss


@startjs
<script>

    async function edit_user(form, route) {

        name = $(form.querySelector('input[name="name"]')).val()
        surname = $(form.querySelector('input[name="surname"]')).val()
        login = $(form.querySelector('input[name="login"]')).val()
        email = $(form.querySelector('input[name="email"]')).val()
        phone = $(form.querySelector('input[name="phone"]')).val()
        password = $(form.querySelector('input[name="password"]')).val()
        password_confirmation = $(form.querySelector('input[name="password_confirmation"]')).val()

        const response = await post(route, {
            name: name,
            surname: surname,
            login: login,
            email: email,
            phone: phone,
            password: password,
            password_confirmation: password_confirmation
        }, true, true)

        if (response.success) {
            $(form.querySelector('.message.error')).css('display', 'none')

            $(form.querySelector('.message.success')).css('display', 'block')

        } else {
            $(form.querySelector('.message.success')).css('display', 'none')

            $(form.querySelector('.message.error')).css('display', 'block')

            if (response.data.password){
                $(form.querySelector('.message.error')).text(response.data.password[0])
            } else if (response.data.phone) {
                $(form.querySelector('.message.error')).text(response.data.phone[0])
            } else if (response.data.email) {
                $(form.querySelector('.message.error')).text(response.data.email[0])
            } else if (response.data.password_confirmation) {
                $(form.querySelector('.message.error')).text(response.data.password_confirmation[0])
            }
        }

    }

</script>
@endjs