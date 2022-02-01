<div class="page-article mb-100">
    <div class="container">
        <div class="page-article-inner">

            <h1 class="h2 color-text">{{ $article->title }}</h1>
            <div class="page-article-image-wrapper">
                <img src="{{ $article->main_image }}" srcset="/images/lazy.svg" alt="" class="page-article-image">
                <x-elements.tag>
                    {{ date_format( date_create($article->created_at), 'd.m.Y') }}
                </x-elements.tag>
            </div>

            <x-inc.content>
                {!! Field::content_images($article->content) !!}
            </x-inc.content>
            
        </div>
    </div>
</div>


@desktopcss
<style>

    .page-article-image-wrapper {
        position: relative;
        width: 100%;
        height: 450px;
        margin: 30px 0;
    }
    .page-article-image {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        z-index: -1;
        object-fit: cover;
    }

</style>
@mobilecss
<style>

    .page-article-image-wrapper {
        position: relative;
        width: 100%;
        height: 326px;
        margin: 20px 0 25px;
    }
    .page-article-image {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        z-index: -1;
        object-fit: cover;
    }

</style>
@endcss
