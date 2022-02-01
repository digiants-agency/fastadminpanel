<a href="{{ route('catalog', $category->slug, false) }}" class="category">
    <img src="{{ $category->image }}" srcset="/images/lazy.svg" alt="{{ $category->title }}" class="category-image">
    <div class="h4 color-text">{{ $category->title }}</div>
</a>

@desktopcss

<style>

    .category-image {
        width: 400px;
        height: 286px;
        object-fit: cover;
        margin-bottom: 10px;
    }

    .category {
        display: flex;
        flex-direction: column;
    }

</style>

@mobilecss

<style>

    .category-image {
        width: 290px;
        height: 210px;
        object-fit: cover;
        margin-bottom: 8px;
    }

    .category {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 23px;
    }

    .category:last-child{
        margin-bottom: 0;
    }

    
</style>

@endcss
