@props(['textarea' => false])

@if ($textarea)
    <textarea 
        {{ $attributes->merge([ 'class' => 'textarea input input-'.$class ]) }} 
        placeholder="{{ $placeholder }}" 
        type="{{ $type }}" 
        @if ($required)
            required
        @endif
    ></textarea>

@else

    <input {{ $attributes->merge([ 'class' => 'input input-'.$class ]) }} 
        placeholder="{!! $placeholder !!}" 
        type="{{ $type }}" 
        @if($required)    
            required
        @endif
    >
@endif

@desktopcss

<style>

    .input {
        width: 100%;
        padding: 12px 20px;
        font-family: "Futura PT";
        font-style: normal;
        font-weight: normal;
        font-size: 16px;
        line-height: 26px;
        border: 1px solid var(--color-back-and-stroke);
        border-radius: 6px;
    }

    .input::placeholder {
        color: var(--color-grey);
    }


    .input-contacts {
        padding: 18px 40px;
    }

    .textarea {
        min-height: 120px;
    }

    .textarea::-webkit-input-placeholder{
        color: var(--color-grey);
    }

</style>

@mobilecss

<style>

    .input {
        width: 100%;
        padding: 9px 15px;
        font-family: "Futura PT";
        font-style: normal;
        font-weight: normal;
        font-size: 13px;
        line-height: 23px;
        border: 1px solid var(--color-back-and-stroke);
        border-radius: 6px;
    }

    .input::placeholder {
        color: var(--color-grey);
    }

    .input-contacts {
        padding: 8px 15px;
    }

    .textarea {
        min-height: 120px;
    }

    .textarea::-webkit-input-placeholder{
        color: var(--color-grey);
    }

</style>

@endcss
