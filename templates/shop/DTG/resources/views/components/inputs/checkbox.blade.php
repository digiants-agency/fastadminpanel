@props(['checked' => false])

<div class="input-group">
    <label class="containercheckbox">
        <input type="checkbox" name="{{ $name }}" @if( $checked ) checked @endif value="{{ $value }}" onchange="{{ $onchange }}" @if($required) required @endif>
        <span class="checkmark"></span>
        {{ $slot }}
    </label>
</div>



@desktopcss

<style>

    .containercheckbox {
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        width: 100%;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .containercheckbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 1px;
        width: 1px;
    }

    .checkmark {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        right: 0;
        height: 20px;
        width: 20px;
        background-color: var(--color-back-and-stroke);
        transition: .3s;
        border-radius: 2px;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .containercheckbox input:checked~.checkmark:after {
        display: block;
        opacity: 1;
    }

    .containercheckbox input:checked~.checkmark {
        background: var(--color-second);
    }

    .containercheckbox .checkmark:after {
        left: 50%;
        top: calc(50% - 2px);
        transform: translate(-50%, -50%) rotate(45deg);
        width: 4px;
        height: 8px;
        border: solid var(--color-white);
        border-width: 0 2.1px 2.1px 0;
        transition: .3s;
        z-index: 10;
    }
</style>

@mobilecss
<style>

    .containercheckbox {
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        width: 100%;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .containercheckbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 1px;
        width: 1px;
    }

    .checkmark {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        right: 0;
        height: 20px;
        width: 20px;
        background-color: var(--color-back-and-stroke);
        transition: .3s;
        border-radius: 2px;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .containercheckbox input:checked~.checkmark:after {
        display: block;
        opacity: 1;
    }

    .containercheckbox input:checked~.checkmark {
        background: var(--color-second);
    }

    .containercheckbox .checkmark:after {
        left: 50%;
        top: calc(50% - 2px);
        transform: translate(-50%, -50%) rotate(45deg);
        width: 4px;
        height: 8px;
        border: solid var(--color-white);
        border-width: 0 2.1px 2.1px 0;
        transition: .3s;
        z-index: 10;
    }
</style>
@endcss