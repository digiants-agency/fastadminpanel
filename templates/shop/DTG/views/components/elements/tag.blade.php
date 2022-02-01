<div class="tag">
    {{ $slot }}
</div>

@desktopcss

<style>
    .tag{
        display: block;
        background: var(--color-main);
        border-radius: 0px 6px 6px 0px;
        padding: 5px 15px;
        font-style: normal;
        font-weight: 450;
        font-size: 14px;
        line-height: 22px;
        color: var(--color-white);
        position: absolute;
        top: 19px;
        left: 0;
        pointer-events: none;
    }
</style>

@mobilecss
<style>
    .tag{
        display: block;
        background: var(--color-main);
        border-radius: 0px 6px 6px 0px;
        padding: 4px 10px;
        font-style: normal;
        font-weight: 450;
        font-size: 12px;
        line-height: 20px;
        color: var(--color-white);
        position: absolute;
        top: 19px;
        left: 0;
        pointer-events: none;
    }
</style>

@endcss