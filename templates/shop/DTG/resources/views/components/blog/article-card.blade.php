<div class="article">
    <x-elements.tag>
        {{ date_format( date_create($article->created_at), 'd.m.Y') }}
    </x-elements.tag>

    <a href="{{ route('blog', $article->slug, false) }}"><img src="{{ $article->image }}" alt="" class="article-image"></a>
    <div class="article-content">
        
        <div class="article-content-text">
            <a href="{{ route('blog', $article->slug, false) }}" class="h4 color-text article-content-title">{{ $article->title }}</a>
            <div class="main-text color-text article-content-desc">{!! $article->short_description !!}</div>
        </div>

        <x-inputs.button href="{{ route('blog', $article->slug, false) }}" type="empty" size="small">
            {{ $fields['button_text'] }}
        </x-inputs.button>
    </div>
</div>



@desktopcss

<style>
    .article {
        position: relative;
        margin-right: 19px;
        background: #FFFFFF;
        border: 2px solid #F6F6F6;
        box-sizing: border-box;
        border-radius: 20px;
        width: 400px;
        display: flex;
        flex-direction: column;
        transition: .3s;
        margin-bottom: 40px;
    }

    .article:hover {
        box-shadow: 0px 4px 25px 2px #F4F4F4;
    }

    .article-image {
        width: 400px;
        height: 286px;
        object-fit: cover;
        border-radius: 20px 20px 0px 0px;
    }

    .article:nth-child(3n) {
        margin-right: 0;
    }

    .article-content {
        padding: 20px 25px;
        min-height: 265px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: flex-start;
    }

    .article-content-desc {
        margin-top: 8px;
        max-height: 78px;
        overflow: hidden;
    }

    .article-content-title {
        transition: .3s;
    }

    .article-content-title:hover {
        color: var(--color-second);
    }

</style>

@mobilecss

<style>
    .article {
        position: relative;
        margin-bottom: 25px;
        background: #FFFFFF;
        border: 2px solid #F6F6F6;
        box-sizing: border-box;
        border-radius: 20px;
        width: 100%;
        display: flex;
        flex-direction: column;
        transition: .3s;
    }

    .article-image {
        width: 100%;
        height: 260px;
        object-fit: cover;
        border-radius: 20px 20px 0px 0px;
    }

    .article-content {
        padding: 10px 15px 25px;
        min-height: 235px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: flex-start;
    }

    .article-content-desc {
        margin-top: 8px;
        max-height: 80px;
        overflow: hidden;
    }

    .article-content .btn {
        width: 100%;
    }

</style>

@endcss