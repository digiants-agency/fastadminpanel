@if($type == 'btn-submit')
    <button type="submit" {{ $attributes->merge([ 'class' => 'btn '.$type.' btn-'.$size ]) }} onclick="{{ $action }}">
        {{ $slot }}
    </button>
@else

    @if(!empty($href))

        <a href="{{ $href }}" {{ $attributes->merge([ 'class' => 'btn '.$type.' btn-'.$size ]) }} onclick="{{ $action }}">
            {{ $slot }}
        </a>

    @else

        <div {{ $attributes->merge([ 'class' => 'btn '.$type.' btn-'.$size ]) }} onclick="{{ $action }}">
            {{ $slot }}
        </div>

    @endif
@endif


@desktopcss
<style>
    
    .btn {
        display: flex;
        align-items: center;
        justify-content: center;

        font-style: normal;
        font-weight: 450;
        font-size: 18px;
        line-height: 28px;
        text-align: center;
        padding: 11px 36px;
        border-radius: 5px;
        background: var(--color-second);
        border: 2.1px solid var(--color-second);
        color: var(--color-white);
        transition: .3s;
        cursor: pointer;
        text-decoration: none;
        flex-shrink: 0;
    }

    .btn-empty {
        background: none;
        color: var(--color-second);
        border-radius: 6px;
    }

    .btn-dark {
        background: #15615B;
    }

    .btn-horizontal {
        width: 350px;
        display: block;
    }
    
    .btn:hover {
        background: var(--color-white);
        color: var(--color-main);
        border-color: var(--color-main)
    }

    .btn-empty:hover {
        background: var(--color-second);
        color: var(--color-white);
        border-color: var(--color-second)
    }

    .btn-dark:hover {
        background: #0E534E;
        border-color: #0E534E;
        color: var(--color-white);
    }

    .btn-center {
        width: 200px;
        display: block;
        padding: 11px 0;
        margin: 0 auto;
    }

    .btn-small {
        padding: 6px 33px;
    }

    .btn-contacts {
        width: 100%;
        margin-top: 5px;
    }

    .btn-product {
        width: 130px;
    }

    .btn-catalog {
        margin-bottom: 20px;
    }

    .btn-project {
        margin-top: 30px;
    }

    button {
        border: none;
        font-family: var(--font-family);
        width: 100%;
    }

</style>
@mobilecss
<style>
     
    .btn {
        display: flex;
        align-items: center;
        justify-content: center;

        font-style: normal;
        font-weight: 450;
        font-size: 16px;
        text-align: center;
        padding: 10px 23px;
        border-radius: 6px;
        background: var(--color-second);
        border: 2.1px solid var(--color-second);
        color: var(--color-white);
        transition: .3s;
        cursor: pointer;
        text-decoration: none;
        flex-shrink: 0;
    }

    .btn-empty {
        background: none;
        color: var(--color-second);
        border-radius: 6px;
    }

    .btn-dark {
        background: #15615B;
    }

    .btn-horizontal {
        width: 100%;
        padding: 7px 0;
        display: block;
    }
    
    .btn:hover {
        background: var(--color-white);
        color: var(--color-main);
        border-color: var(--color-main)
    }

    .btn-empty:hover {
        background: var(--color-second);
        color: var(--color-white);
        border-color: var(--color-second)
    }

    .btn-dark:hover {
        background: #0E534E;
        border-color: #0E534E;
        color: var(--color-white);
    }

    .btn-center {
        width: 180px;
        display: block;
        padding: 11px 0;
        margin: 0 auto;
    }

    .btn-small {
        padding: 7px 33px;
    }

    .btn-contacts {
        width: 100%;
        margin-top: 5px;
    }

    .btn-product {
        width: 140px;
    }

    .btn-catalog {
        margin-bottom: 20px;
    }

    .btn-project {
        margin-top: 25px;
    }

    button {
        border: none;
        font-family: var(--font-family);
        width: 100%;
    }
</style>
@endcss