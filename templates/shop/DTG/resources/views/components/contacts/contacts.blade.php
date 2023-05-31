<div class="contacts mb-100">
    <div class="container container-contacts">
        <div class="contacts-inner">
            <div class="contacts-content">
                <div class="h2 color-text contacts-title">{{ $fields['title'] }}</div>

                <div class="contacts-items">

                    @foreach ($fields['phones'] as $item)
                        <a href="tel:{{ Field::phone($item[0]) }}" class="contacts-item color-text">
                            <svg class="contacts-item-icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.5643 11.7424L13.3315 9.50954C12.534 8.71209 11.1784 9.0311 10.8594 10.0677C10.6202 10.7855 9.82272 11.1842 9.10502 11.0247C7.51012 10.626 5.35702 8.5526 4.9583 6.87797C4.71906 6.16023 5.19753 5.36279 5.91523 5.12359C6.95191 4.80461 7.27089 3.44895 6.47345 2.65151L4.2406 0.418659C3.60264 -0.139553 2.64571 -0.139553 2.08749 0.418659L0.572347 1.93381C-0.9428 3.5287 0.731836 7.75516 4.47983 11.5031C8.22783 15.2511 12.4543 17.0056 14.0492 15.4106L15.5643 13.8955C16.1226 13.2575 16.1226 12.3006 15.5643 11.7424Z" fill="#059F97"/>
                                <clipPath id="clip0_89_440">
                                <rect width="16" height="16" fill="white"/>
                                </clipPath>
                            </svg>
                            {{ $item[0] }}
                        </a>
                    @endforeach
                    <div class="contacts-item color-text">
                        <svg class="contacts-item-icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 0C3.58862 0 0 3.58862 0 8C0 12.4114 3.58862 16 8 16C12.4114 16 16 12.4114 16 8C16 3.58862 12.4114 0 8 0ZM11.8047 12.1379C11.6747 12.2679 11.504 12.3334 11.3334 12.3334C11.1627 12.3334 10.9919 12.2679 10.8621 12.1379L7.52869 8.80469C7.40332 8.68005 7.33337 8.51062 7.33337 8.33337V4C7.33337 3.63135 7.63196 3.33337 8 3.33337C8.36804 3.33337 8.66663 3.63135 8.66663 4V8.05737L11.8047 11.1953C12.0653 11.4561 12.0653 11.8773 11.8047 12.1379Z" fill="#059F97"/>
                        </svg>
                        {{ $fields['time'] }}
                    </div>
                    <a href="mailto:{{ $fields['email'] }}" class="contacts-item color-text">
                        <svg class="contacts-item-icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.333768 2.97362C2.52971 4.83334 6.38289 8.10516 7.51539 9.12531C7.66742 9.263 7.83049 9.333 7.99977 9.333C8.16871 9.333 8.33149 9.26366 8.48317 9.12663C9.61664 8.10547 13.4698 4.83334 15.6658 2.97362C15.8025 2.85806 15.8234 2.65494 15.7127 2.51366C15.4568 2.18719 15.0753 2 14.6664 2H1.33311C0.924268 2 0.542737 2.18719 0.286893 2.51369C0.176205 2.65494 0.197049 2.85806 0.333768 2.97362Z" fill="#059F97"/>
                            <path d="M15.8067 3.98139C15.6885 3.92639 15.5495 3.94558 15.4512 4.02958C14.0131 5.24864 12.1182 6.85933 10.6892 8.08849C10.614 8.15296 10.5717 8.24767 10.5733 8.34696C10.5749 8.44593 10.6208 8.53933 10.6983 8.60118C12.0261 9.66464 14.0271 11.1276 15.4721 12.1673C15.5297 12.2089 15.598 12.2301 15.6667 12.2301C15.7188 12.2301 15.7709 12.2181 15.8187 12.1933C15.9301 12.1363 16.0001 12.0217 16.0001 11.8967V4.2838C16 4.15392 15.9245 4.03577 15.8067 3.98139Z" fill="#059F97"/>
                            <path d="M0.528 12.1671C1.97331 11.1274 3.97463 9.66451 5.30209 8.60101C5.37956 8.53917 5.42547 8.44573 5.42709 8.34679C5.42872 8.24751 5.38641 8.15279 5.31122 8.08832C3.88216 6.85917 1.98697 5.24848 0.548844 4.02942C0.449875 3.94542 0.310562 3.92688 0.193375 3.98123C0.0755313 4.0356 0 4.15376 0 4.28363V11.8966C0 12.0216 0.07 12.1362 0.181313 12.1932C0.229156 12.2179 0.28125 12.2299 0.333344 12.2299C0.402031 12.2299 0.470375 12.2088 0.528 12.1671Z" fill="#059F97"/>
                            <path d="M15.5915 13.074C14.196 12.0757 11.6254 10.2143 10.0909 8.96887C9.96586 8.86699 9.78486 8.87024 9.66183 8.97637C9.36073 9.23906 9.10877 9.46043 8.93005 9.62122C8.3812 10.1167 7.61948 10.1167 7.06936 9.62056C6.8913 9.46009 6.63936 9.23806 6.33823 8.97634C6.21617 8.86956 6.03486 8.86631 5.90952 8.96884C4.3802 10.2101 1.80664 12.0737 0.408859 13.074C0.331047 13.13 0.280922 13.2163 0.271172 13.3116C0.261734 13.407 0.293297 13.5017 0.358734 13.572C0.611047 13.8439 0.966515 13.9998 1.33339 13.9998H14.6667C15.0336 13.9998 15.3887 13.8439 15.6417 13.5721C15.7068 13.5021 15.7387 13.4074 15.7292 13.312C15.7195 13.2166 15.6693 13.13 15.5915 13.074Z" fill="#059F97"/>
                            <clipPath id="clip0_89_425">
                            <rect width="16" height="16" fill="white"/>
                            </clipPath>
                        </svg>  
                        {{ $fields['email'] }}    
                    </a>
                    <div class="contacts-item">
                        <svg class="contacts-item-icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.20182 0.00333482C4.95254 -0.106167 2.28418 2.49519 2.28418 5.71972C2.28418 9.37922 5.79604 12.035 7.76443 15.8544C7.86437 16.0484 8.14353 16.0486 8.24381 15.8547C10.0245 12.418 13.068 10.1135 13.632 6.80266C14.216 3.37656 11.6753 0.120438 8.20182 0.00333482ZM8.00384 8.71572C6.34922 8.71572 5.00784 7.37431 5.00784 5.71972C5.00784 4.06514 6.34925 2.72372 8.00384 2.72372C9.65846 2.72372 10.9999 4.06514 10.9999 5.71972C10.9999 7.37431 9.65846 8.71572 8.00384 8.71572Z" fill="#059F97"/>
                            <clipPath id="clip0_94_616">
                            <rect width="16" height="16" fill="white"/>
                            </clipPath>
                        </svg>
                        {{ $fields['address'] }}
                    </div>
                    
                </div>

                <div class="contacts-social">
                    @foreach ($fields['social'] as $item)
                        <a href="{{ $item[0] }}" target="_blank" class="contacts-social-item">
                            <img srcset="/images/lazy.svg" src="{{ $item[2] }}" alt="" class="contacts-social-item-icon">
                        </a>    
                    @endforeach
                </div>
            </div>

            <div class="contacts-form-wrapper">
                <img srcset="/images/lazy.svg" src="{{ $fields['form_image'] }}" alt="" class="contacts-form-image">
                <div class="contacts-form-inner">
                    <div class="h2 color-white contacts-form-title">{{ $fields['form_title'] }}</div>
                    <form action="" class="contacts-form">
                        <div class="contacts-form-input-wrapper">
                            <x-inputs.input placeholder="{{ $fields['form_input_1'] }}" class="contacts" name="name" type="text" required/>
                        </div>
                        <div class="contacts-form-input-wrapper">
                            <x-inputs.input placeholder="{{ $fields['form_input_2'] }}" class="contacts" name="phone" type="text" pattern="^[+ 0-9]+$" title="+380681234567" required/>
                        </div>
                        <div class="contacts-form-input-wrapper">
                            <x-inputs.input placeholder="{{ $fields['form_input_3'] }}" class="contacts" name="email" type="email" required/>
                        </div>
                        <div class="contacts-form-input-wrapper">
                            <x-inputs.input placeholder="{{ $fields['form_input_4'] }}" class="contacts" name="message" type="text" />
                        </div>
                        <div class="contacts-form-input-wrapper">
                            <x-inputs.button type="submit" size="contacts">
                                {{ $fields['button_text'] }}
                            </x-inputs.button>
                        </div>

                        <div class="form-answer main-text color-green success">{{ $fields['message_1'] }}</div>
                        <div class="form-answer main-text color-red error">{{ $fields['message_2'] }}</div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>


@desktopcss

<style>

    .container-contacts {
        padding-right: 0;
    }

    .contacts-content {
        padding-top: 72px;
    }

    .contacts-title {
        margin-bottom: 40px;
    }

    .contacts-item-icon {
        width: 16px;
        height: 16px;
        margin-right: 13px;
        flex-shrink: 0;
    }

    .contacts-item-icon path {
        fill: var(--color-second);
    }

    .contacts-item {
        font-style: normal;
        font-weight: 450;
        font-size: 24px;
        line-height: 32px;
        display: flex;
        align-items: center;
        margin-bottom: 25px;

        transition: .3s;
    }

    .contacts-item:hover {
        color: var(--color-second);
    }

    .contacts-social {
        display: flex;
        align-items: center;
    }

    .contacts-social-item {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border: 1px solid var(--color-second);
        border-radius: 50%;
        margin-right: 15px;
        transition: .3s;
        overflow: hidden;
        
    }

    .contacts-social-item-icon {
        width: 16px;
        height: 16px;
        transition: .1s linear;
        
    }

    .contacts-social-item:hover {
        background-color: var(--color-second);
    }

    .contacts-social-item:hover .contacts-social-item-icon {
        filter: brightness(0) invert(1);
    }   

    .contacts-form-title {
        margin-bottom: 48px;
    }

    .contacts-inner {
        display: flex;
        justify-content: space-between;
    }

    .contacts-form-wrapper {
        position: relative;
        width: 903px;
        height: 663px;
        padding: 72px 206px 110px 106px;
        background: #000000;
    }

    .contacts-form-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        opacity: .45;
    }

    .contacts-form-inner {
        position: relative;
        z-index: 1;
    }

    .contacts-form-input-wrapper {
        margin-bottom: 20px;
    }


    
</style>

@mobilecss
<style>

    .contacts-content {
        padding-top: 25px;
    }

    .contacts-title {
        margin-bottom: 20px;
    }

    .contacts-item-icon {
        width: 14px;
        height: 14px;
        margin-right: 10px;
    }

    .contacts-item-icon path {
        fill: var(--color-second);
    }

    .contacts-item {
        font-style: normal;
        font-weight: 450;
        font-size: 16px;
        line-height: 18px;
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .contacts-social {
        display: flex;
        align-items: center;
    }

    .contacts-social-item {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 35px;
        height: 35px;
        border: 1px solid var(--color-second);
        border-radius: 50%;
        margin-right: 10px;
        overflow: hidden;        
    }

    .contacts-social-item-icon {
        width: 14px;
        height: 14px;
        transition: .1s linear;
        
    }

    .contacts-form-title {
        margin-bottom: 20px;
        font-size: 22px;
        line-height: 26px;
    }


    .contacts-form-wrapper {
        position: relative;
        width: 100%;
        min-height: 335px;
        margin-top: 40px;
        padding: 25px 20px 30px;
        background: #000000;
        border-radius: 5px;
    }

    .contacts-form-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 0;
        opacity: .45;
        border-radius: 5px;
    }

    .contacts-form-inner {
        position: relative;
        z-index: 1;
    }

    .contacts-form-input-wrapper {
        margin-bottom: 8px;
    }

    .contacts-form-input-wrapper:last-child{
        margin-bottom: 10px;
    }
    
</style>
@endcss


@startjs
<script>

    $('.contacts-form').on('submit', async function(e){
        e.preventDefault();
        
        name = $(this).el[0].querySelectorAll('input[name="name"]')[0].value
        phone = $(this).el[0].querySelectorAll('input[name="phone"]')[0].value
        email = $(this).el[0].querySelectorAll('input[name="email"]')[0].value
        message = $(this).el[0].querySelectorAll('input[name="message"]')[0].value

        
        const response = await post(lang + '/api/send-contacts', {
            name: name,
            phone: phone,
            email: email,
            message: message,
        }, true, true)

        
        if (response.success){
            
            $($(this).el[0].querySelectorAll('.form-answer.error')[0]).css('display', 'none')
            $($(this).el[0].querySelectorAll('.form-answer.success')[0]).css('display', 'block')

            $(this).el[0].reset()
        } else {
            $($(this).el[0].querySelectorAll('.form-answer.error')[0]).css('display', 'none')
            $($(this).el[0].querySelectorAll('.form-answer.success')[0]).css('display', 'block')
        }

        return false;
    })
    
</script>
@endjs