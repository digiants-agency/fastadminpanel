@if (!$title->isEmpty() && !$content->isEmpty())
    <div class="seo mb-100">
        <div class="container">
            <div class="seo-inner">
                <div class="h2 color-text seo-title">{{ $title }}</div>
                <div class="seo-content">
                    <x-inc.content>
                        {!! $content !!}
                    </x-inc.content>
                </div>
            </div>
        </div>
    </div>
@endif


@desktopcss

<style>

    .seo {
        order: 10000;
    }

    .seo-inner {
        background: var(--color-back-and-stroke);
        border-radius: 10px;
        padding: 40px 50px;
    }

    .seo-title{
        margin-bottom: 20px;
    }

    .seo-content{
        height: 224px;
        overflow: auto;
    }

    .seo-content::-webkit-scrollbar {
        width: 4.1px;
    }

    .seo-content::-webkit-scrollbar-track {
        background: #E4E4E4;
    }

    .seo-content::-webkit-scrollbar-thumb {
        background: var(--color-main);
    }

</style>

@mobilecss
<style>

    .seo {
        order: 10000;
    }

    .seo-inner {
        background: var(--color-back-and-stroke);
        padding: 25px 20px;
    }

    .seo-title{
        margin-bottom: 10px;
    }

    .seo-content{
        height: 260px;
        overflow: auto;
        padding-right: 20px;
    }

    .seo-content::-webkit-scrollbar {
        width: 4.1px;
    }

    .seo-content::-webkit-scrollbar-track {
        background: #E4E4E4;
    }

    .seo-content::-webkit-scrollbar-thumb {
        background: var(--color-main);
    }

</style>
@endcss