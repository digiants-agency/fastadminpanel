<div class="input-radio">                         
    <input type="radio" value="{{ $value }}" name="{{ $name }}" id="{{ $value }}" data-price="{{ $price }}" @if($checked) checked @endif>
    <span class="checkmark"></span>
    <label for="{{ $value }}" class="input-radio-label">
        
        <div class="input-radio-label-description">
            <span class="extra-text color-text radio-title">{{ $title }}</span>
            <span class="extra-text color-grey radio-desc">{{ $description }}</span>
        </div>

        <span class="h5 color-text radio-price">{{ $price }}</span>
    </label>
</div>

@desktopcss
<style>
    .input-radio {
        width: 100%;
        border-radius: 5px;
        display: flex;
        border: 1px solid var(--color-back-and-stroke);
        box-sizing: border-box;
        padding: 10px 15px;
        margin-bottom: 15px;
        cursor: pointer;
        position: relative;
    }

    .input-radio-label {
        display: flex;
        align-items: center;
        width: 100%;
        justify-content: space-between;
        padding-left: 50px;
        cursor: pointer;
        position: relative;
        z-index: 10;
    }

    .input-radio-label-description {
        display: flex;
        flex-direction: column;
    }

    .input-radio input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .input-radio .checkmark {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 15px;
        height: 20px;
        width: 20px;
        border: 1px solid var(--color-back-and-stroke);
        background-color: var(--color-white);
        border-radius: 50%;
        padding: 0;
        transition: .3s;
    }

    .input-radio:hover input~.checkmark {
        background-color: var(--color-back-and-stroke);
    }

    .input-radio input:checked~.checkmark::before {
        opacity: 1;
    }

    .input-radio .checkmark::before {
        content: "";
        display: block;
        width: 10px;
        height: 10px;
        position: absolute;
        z-index: 1;
        top: 50%;
        left: 50%;
        transform: translate3d(-50%, -50%, 0);
        border-radius: 50%;
        background-color: var(--color-second);
        opacity: 0;
        transition: .3s;
    }

    .input-radio .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .input-radio input:checked~.input-radio .checkmark:after {
        display: block;
        top: 5px;
        left: 5px;
        width: 10px;
        height: 10px;
        background-color: var(--color-white);
    }

    .input-radio .checkmark:after {
        top: 9px;
        left: 9px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--color-white);
    }


    .radio_title {
        font-style: normal;
        font-weight: normal;
        font-size: 16px;
        line-height: 22px;
        color: var(--color-second);
        width: 263px;
        margin-bottom: 4px;
    }

    .radio_desc {
        font-style: normal;
        font-weight: 300;
        font-size: 14px;
        line-height: 22px;
        color: rgba(64, 64, 64, 0.5);
    }

    .radio_price {
        font-style: normal;
        font-weight: 300;
        font-size: 14px;
        line-height: 22px;
        color: #404040;
    }
</style>
@mobilecss
<style>
    .input-radio {
        width: 100%;
        border-radius: 5px;
        display: flex;
        border: 1px solid var(--color-back-and-stroke);
        box-sizing: border-box;
        padding: 15px;
        margin-bottom: 12px;
        cursor: pointer;
        position: relative;
    }

    .input-radio-label {
        width: 100%;
        padding-left: 35px;
        cursor: pointer;
        position: relative;
        z-index: 10;
    }

    .input-radio-label-description {
        display: flex;
        flex-direction: column;
    }

    .input-radio input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .input-radio .checkmark {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 15px;
        height: 20px;
        width: 20px;
        border: 1px solid var(--color-back-and-stroke);
        background-color: var(--color-white);
        border-radius: 50%;
        padding: 0;
        transition: .3s;
    }

    .input-radio:hover input~.checkmark {
        background-color: var(--color-back-and-stroke);
    }

    .input-radio input:checked~.checkmark::before {
        opacity: 1;
    }

    .input-radio .checkmark::before {
        content: "";
        display: block;
        width: 10px;
        height: 10px;
        position: absolute;
        z-index: 1;
        top: 50%;
        left: 50%;
        transform: translate3d(-50%, -50%, 0);
        border-radius: 50%;
        background-color: var(--color-second);
        opacity: 0;
        transition: .3s;
    }

    .input-radio .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .input-radio input:checked~.input-radio .checkmark:after {
        display: block;
        top: 5px;
        left: 5px;
        width: 10px;
        height: 10px;
        background-color: var(--color-white);
    }

    .input-radio .checkmark:after {
        top: 9px;
        left: 9px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--color-white);
    }


    .radio_title {
        font-style: normal;
        font-weight: normal;
        font-size: 14px;
        line-height: 24px;
        color: var(--color-second);
    }

    .radio_desc {
        font-style: normal;
        font-weight: normal;
        font-size: 13px;
        line-height: 20px;
        color: rgba(64, 64, 64, 0.5);
        margin-bottom: 5px;
    }

    .radio_price {
        font-style: normal;
        font-weight: 500;
        font-size: 13px;
        line-height: 20px;
        color: #404040;
    }
</style>
@endcss