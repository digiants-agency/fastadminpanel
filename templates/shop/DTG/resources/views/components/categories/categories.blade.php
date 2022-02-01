@props(['button' => false, 'page' => false])

<div class="categories mb-100">
    <div class="container">
        
        @if($page)
            <div class="h2 color-text categories-title">{{ $fields['title'] }}</div>
            <div class="main-text color-text categories-desc">{{ $fields['description'] }}</div>
        @endif

        <div class="categories-inner @if($button) with-btn @endif">
            @foreach ($categories as $category)
                <x-categories.category :category="$category" />
            @endforeach
        </div>

        @if ($button)
            <x-inputs.button type="center" href="{{ Lang::link($fields['button_link']) }}">
                {{ $fields['button_text'] }}
            </x-inputs.button>    
        @endif

    </div>
</div>

@desktopcss

<style>

    .categories-inner {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        grid-gap: 40px 15px;
    }

    .categories-inner.with-btn{
        margin-bottom: 40px;
    }
    
    .categories-title{
        margin-bottom: 15px;
    }

    .categories-desc {
        width: 740px;
        margin-bottom: 30px;
    }

</style>

@mobilecss

<style>
    
    .categories-inner.with-btn{
        margin-bottom: 23px;
    }

    .categories-title{
        margin-bottom: 15px;
    }

    .categories-desc {
        margin-bottom: 25px;
    }

</style>

@endcss
