<div class="product-description-header">
    <div class="h3 color-second product-description-title">{{ $title }}</div>
</div>

<div class="reviews-block">

    <div class="reviews-inner">

        <div class="reviews" id="reviews" data-id="{{ $product->id }}">
            <x-products.product-description.reviews-block :reviews="$product->reviews" />
        </div>
        @if(sizeof($product->reviews) < $product->reviews_count)
            <x-inputs.button type="empty" data-page="1" action="show_more_reviews(this)">
                {{ $fields['button_text'] }}
            </x-inputs.button>
        @endif
    </div>

    <x-products.product-description.reviews-form :id="$product->id"/>

</div>


@desktopcss
<style>
    
    .reviews-block {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .reviews-inner {
        display: flex;
        flex-direction: column;
        align-items: flex-start; 
    }

</style>
@mobilecss
<style>
    
    .reviews-block {
        width: 100%;
    }

    .reviews-inner {
        display: flex;
        flex-direction: column;
        align-items: flex-start; 
        margin-bottom: 30px;
    }

</style>
@endcss

@startjs
<script>
    
    async function show_more_reviews(elm){
        page = parseInt($(elm).data('page')) + 1
        
        const response = await post('/api/show-more-reviews', {
            page: page,
            id: $('#reviews').data('id'),
        }, true, true)

        if (response.success){
            $('#reviews').html($('#reviews').html() + response.data.html)
            count_elements = $('.review').el.length
            
            if (count_elements === response.data.count){
                $(elm).css('display', 'none')
            } else {
                $(elm).data('page', page)
            }
        } else {

        }
    }

</script>
@endjs