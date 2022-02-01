<div class="product-description-block mb-100">

    @if(sizeof($product->characteristics))
        <x-products.product-description.characteristics title="{{ $fields['characteristics_title'] }}" :characteristics="$product->characteristics" />
    @endif

    @if(!empty($product->description))
        <x-products.product-description.description title="{{ $fields['description_title'] }}" :content="$product->description" />
    @endif

    <x-products.product-description.reviews title="{{ $fields['reviews_title'] }}" :product="$product" />

</div>


@desktopcss
<style>
    
    .product-description-block {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .product-description-header {
        margin-top: 60px;
        margin-bottom: 30px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;  
        width: 100%;
        border-bottom: 1px solid var(--color-back-and-stroke);
    }
    .product-description-title {
        padding: 0 30px 6px;
        border-bottom: 3px solid var(--color-second);
    }

</style>
@mobilecss
<style>
    
    .product-description-block {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .product-description-header {
        margin-top: 40px;
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;  
        width: 100%;
        border-bottom: 1px solid var(--color-back-and-stroke);
    }
    .product-description-title {
        padding: 0 20px 5px;
        border-bottom: 3px solid var(--color-second);
    }

</style>
@endcss