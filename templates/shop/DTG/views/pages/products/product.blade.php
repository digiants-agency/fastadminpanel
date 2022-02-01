<x-layout>

	<?php $s = new Single('Каталог', 10, 1); ?>

	<x-inc.breadcrumbs :breadcrumbs="$breadcrumbs"/>

    <div class="container">

        <div class="product-inner">
            
            <x-sliders.slider-product :images="$product->gallery" />
            
            <x-products.product-info :product="$product" />

        </div>
        <x-products.product-description :product="$product" />

        <div class="products-recomended mb-100">
        
			<div class="main-h1 h2 color-text">{{ $s->field('Категории', 'Заголовок Рекомендуемые товары', 'text', true, 'Рекомендуемые товары') }}</div>

            <x-products.products row="4" :products="$recomended"/>
        
		</div>
        
    </div>

	
	<x-slot name="meta_title">
		{{ $product->meta_title }}
	</x-slot>
	
	<x-slot name="meta_description">
		{{ $product->meta_description }}
	</x-slot>
	
	<x-slot name="meta_keywords">
		{{ $product->meta_keywords }}
	</x-slot>
	

</x-layout>
