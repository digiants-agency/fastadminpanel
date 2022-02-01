<div class="horizontal mb-100">
    <div class="container">
        <div class="horizontal-inner">
            
            <img src="{{ $fields['image'] }}" srcset="/images/lazy.svg" alt="" class="horizontal-image desktop">
            <img src="{{ $fields['image_mobile'] }}" srcset="/images/lazy.svg" alt="" class="horizontal-image mobile">


            <div class="horizontal-content">
                <div class="@if(Platform::desktop()) h2 @else h3 @endif color-white horizontal-title">{{ $fields['title'] }}</div>
                <div class="main-text color-white horizontal-desc">{{ $fields['description'] }}</div>
                <form action="" class="horizontal-form">
                    <div class="horizontal-form-input">
                        <x-inputs.input name="name" placeholder="{{ $fields['input_1'] }}" type="text" required/>
                    </div>
                    <div class="horizontal-form-input">
                        <x-inputs.input name="phone" placeholder="{{ $fields['input_2'] }}" type="text" pattern="^[+ 0-9]+$" title="+380681234567" required/>
                    </div>

                    <input class="input" type="hidden" name="link" value="{{ url()->current() }}">

                    <div class="horizontal-form-input">
                        <x-inputs.button type="submit" size="horizontal">
                            {{ $fields['button_text'] }}
                        </x-inputs.button>
                    </div>
                </form>

                <div class="form-answer main-text color-green success">{{ $fields['message_1'] }}</div>
                <div class="form-answer main-text color-red error">{{ $fields['message_2'] }}</div>
            </div>
        </div>
    </div>
</div>


@desktopcss

<style>

    .horizontal-inner {
        position: relative;
        min-height: 265px;
        border-radius: 6px;
        background: rgba(0, 0, 0, 1);
    }

    .horizontal-image {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 0;
        width: 100%;
        height: 100%;
        border-radius: 6px;
        opacity: .45;
        object-fit: cover;
    }

    .horizontal-content {
        position: relative;
        z-index: 1;
        padding: 40px 60px 70px;
    }

    .horizontal-form {
        display: flex;
        align-items: center;
        justify-content: space-between;

    }

    .horizontal-form-input {
        width: 350px;
    }

    .horizontal-title {
        text-align: center;
        margin-bottom: 5px; 
    }

    .horizontal-desc {
        text-align: center;
        margin-bottom: 36px; 
    }

    .form-answer{
        margin-top: 5px;
    }

</style>

@mobilecss

<style>

    .horizontal-inner {
        position: relative;
        min-height: 318px;
        border-radius: 5px;
        background: rgba(0, 0, 0, 1);
    }

    .horizontal-image {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 0;
        width: 100%;
        height: 100%;
        opacity: .45;
        object-fit: cover;
        border-radius: 5px;
    }

    .horizontal-content {
        position: relative;
        z-index: 1;
        padding: 20px;
    }

    .horizontal-form-input {
        width: 100%;
        margin-bottom: 8px;
    }

    .horizontal-title {
        text-align: center;
        margin-bottom: 8px; 
    }

    .horizontal-desc {
        text-align: center;
        margin-bottom: 15px; 
    }

    .form-answer{
        margin-top: 5px;
    }

</style>

@endcss



@js
<script>
    
    $('.horizontal-form').on('submit', async function(e){

        e.preventDefault()

        name = $(this).el[0].querySelectorAll('input[name="name"]')[0].value
        phone = $(this).el[0].querySelectorAll('input[name="phone"]')[0].value
        link = $(this).el[0].querySelectorAll('input[name="link"]')[0].value
        
        const response = await post(lang + '/api/send-horizontal', {
            name: name,
            phone: phone,
            link: link,
        }, true, true)

        
        if (response.success){

            $($(this).el[0].closest('.horizontal-content').querySelectorAll('.form-answer.error')[0]).css('display', 'none')
            $($(this).el[0].closest('.horizontal-content').querySelectorAll('.form-answer.success')[0]).css('display', 'block')

            $(this).el[0].reset()
        } else {
            $($(this).el[0].closest('.horizontal-content').querySelectorAll('.form-answer.error')[0]).css('display', 'block')
            $($(this).el[0].closest('.horizontal-content').querySelectorAll('.form-answer.success')[0]).css('display', 'none')
        }

        return false;
    })

</script>
@endjs