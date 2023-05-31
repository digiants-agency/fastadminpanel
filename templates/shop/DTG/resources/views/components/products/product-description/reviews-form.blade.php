<form class="reviews-form" id="reviews-form" onsubmit="submit_reviews_form(event)">
    <div class="h2 color-white reviews-form-title">{{ $fields['title'] }}</div>
    <div class="main-text color-white reviews-form-desc">{{ $fields['description'] }}</div>

    <x-inputs.input name="name" placeholder="{{ $fields['form_input_1'] }}" required/>
    <x-inputs.input name="phone" placeholder="{{ $fields['form_input_2'] }}" required/>
    <x-inputs.input name="email" placeholder="{{ $fields['form_input_3'] }}" type="email" required/>
    <x-inputs.input name="message" placeholder="{{ $fields['form_input_4'] }}" textarea required/>

    <input class="input" type="hidden" name="id_products" value="{{ $id }}">

    <x-inputs.button type="submit" size="dark">
        {{ $fields['button_text'] }}
    </x-inputs.button>
    
    <div class="form-answer main-text color-green success">{{ $fields['message_1'] }}</div>
    <div class="form-answer main-text color-red error">{{ $fields['message_2'] }}</div>

</form>

@desktopcss
<style>

    .reviews-form {
        padding: 20px 105px 30px;
        background-color: var(--color-second);
        border-radius: 5px;
        width: 560px;
    }

    .reviews-form-title {
        text-align: center;
        margin-bottom: 5px;
    }

    .reviews-form-desc {
        text-align: center;
        margin-bottom: 20px;
    }

    .reviews-form input {
        margin-bottom: 10px;
    }

</style>
@mobilecss
<style>

    .reviews-form {
        padding: 20px 20px 25px;
        background-color: var(--color-second);
        border-radius: 5px;
        width: 100%;
    }

    .reviews-form-title {
        text-align: center;
        margin-bottom: 8px;
    }

    .reviews-form-desc {
        text-align: center;
        margin-bottom: 15px;
    }

    .reviews-form input {
        margin-bottom: 8px;
    }

</style>
@endcss

@startjs
<script>
    
    async function submit_reviews_form(e){
        e.preventDefault()

        name = $('#reviews-form input[name="name"]').val()
        phone = $('#reviews-form input[name="phone"]').val()
        email = $('#reviews-form input[name="email"]').val()
        message = $('#reviews-form textarea[name="message"]').val()
        id_products = $('#reviews-form input[name="id_products"]').val()
        
        const response = await post('/api/send-review', {
            name: name,
            phone: phone,
            email: email,
            message: message,
            id_products: id_products,
        }, true, true)

        
        if (response.success){
            $('.form-answer.error').css('display', 'none')
            $('.form-answer.success').css('display', 'block')
            $('#reviews-form').el[0].reset()
        } else {
            $('.form-answer.error').css('display', 'block')
            $('.form-answer.success').css('display', 'none')
        }

        return false;
    }

</script>
@endjs