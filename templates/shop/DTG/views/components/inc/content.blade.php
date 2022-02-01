<div class="content">
    
    @if(isset($h1))
        <h1 class="h2 color-text">{{ $h1 }}</h1>
    @endif

    {{ $slot }}
</div>

@desktopcss

<style>

    .content {
        color: var(--color-text);
    }

    .content figure {
        margin: 0;
    }

    .content p {
        max-width: 1030px;
        margin: 15px 0;
    }

    .content ul, 
    .content ol {
        margin: 15px 0;
    }

    .content li {
        max-width: 1030px;
        margin: 5px 20px;
        padding-left: 10px;
    }

    .content li::marker {
        color: var(--color-second);
    }

    .content img {
        width: 100%;
        margin: 30px 0;
    }
    
    .content-images {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .content-images img {
        width: 595px;
        height: 450px;
        object-fit: cover;
    }

    .content blockquote {
        margin: 0;
        padding: 50px 60px;
        border: 1px solid var(--color-main);
        box-sizing: border-box;
        margin: 40px 0;
        position: relative;
        width: 1130px;
    }

    .content blockquote:before {
        content: "";
        display: block;
        position: absolute;
        top: -25px;
        left: 20px;
        width: 50px;
        height: 50px;
        padding: 0 13px;
        background-color: #FFFFFF;
        background-image: url('/images/quote.svg');
        background-position: center;
        background-repeat: no-repeat;
        background-size: 50px;
    }

    .content blockquote p {
        font-style: normal;
        font-weight: normal;
        font-size: 18px;
        line-height: 26px;
        text-align: center;
        color: var(--color-second);
        width: 100%;
    }
    
</style>

@mobilecss

<style>

    .content {
        color: var(--color-text);
    }

    .content figure {
        margin: 0;
    }

    .content h3{
        margin-top: 30px;
    }

    .content ul, 
    .content ol,
    .content p {
        margin: 10px 0;
    }

    .content li {
        margin: 5px 15px;
        padding-left: 5px;
    }

    .content li::marker {
        color: var(--color-second);
    }

    .content img {
        width: 100%;
        min-height: 326px;
        object-fit: cover;
        margin: 20px 0;
    }

    .content-images img {
        width: 100%;
        object-fit: cover;
        margin-bottom: 10px;
    }

    .content blockquote {
        margin: 0;
        padding: 25px 23px;
        border: 1px solid var(--color-main);
        box-sizing: border-box;
        margin: 30px 0;
        position: relative;
        width: 100%;
    }

    .content blockquote:before {
        content: "";
        display: block;
        position: absolute;
        top: -17px;
        left: 17px;
        width: 37px;
        height: 37px;
        padding: 0 7px;
        background-color: #FFFFFF;
        background-image: url('/images/quote.svg');
        background-position: center;
        background-repeat: no-repeat;
        background-size: 37px;
    }

    .content blockquote p {
        font-style: normal;
        font-weight: normal;
        font-size: 16px;
        line-height: 20px;
        text-align: center;
        color: var(--color-second);
        width: 100%;
    }
</style>

@endcss