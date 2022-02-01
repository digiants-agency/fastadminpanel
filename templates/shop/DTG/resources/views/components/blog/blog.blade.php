<div class="index-blog @if($index) index-page-blog @endif">
    <div class="container-offset">
        <div class="h2 color-text">@if(!empty($title)) {{ $title }} @else {{ $fields['title'] }} @endif</div>
        <div class="blog-inner">
            @foreach ($articles as $article)
                <x-blog.article-card :article="$article" />
            @endforeach
        </div>
    </div>
</div>


@desktopcss

<style>

    .blog-inner{
        display: flex;
        flex-wrap: wrap;
        margin-top: 30px;
    }
     
    .index-page-blog {
        margin-bottom: 60px;
    }
    
</style>

@mobilecss

<style>
    
    .blog-inner{
        display: flex;
        flex-wrap: wrap;
        margin-top: 20px;
    }
     
    .index-page-blog {
        margin-bottom: 15px;
    }

</style>

@endcss
