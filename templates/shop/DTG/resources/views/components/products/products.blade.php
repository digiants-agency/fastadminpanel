@if(sizeof($products))
    <div class="products products-row-{{ $row }}">
        @foreach($products as $product)
            <x-products.product-card :product="$product" />
        @endforeach
    </div>
@else
    <div class="h4 color-text">{{ $fields['none_products'] }}</div>
@endif


@desktopcss
<style>
    
    .products {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
    }

    .products .product-card:nth-child({{ $row }}n) {
        margin-right: 0;
    }

</style>
@mobilecss
<style>
    
    .products {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        width: 100%;
    }

    .products .product-card:nth-child(2n) {
        margin-right: 0;
    }

</style>
@endcss