<x-layout>

	<?php $s = new Single('Каталог', 10, 1); ?>

	<x-inc.seo>
		<x-slot name="title">
			{{ $s->field('SEO text', 'Заголовок', 'text', true, 'Seo Text') }}
		</x-slot>

		<x-slot name="content">
			{!! $s->field('SEO text', 'Контент', 'ckeditor', true, '') !!}
		</x-slot>
	</x-inc.seo>

	<x-inc.breadcrumbs :breadcrumbs="$breadcrumbs"/>

	<div class="container">
		<h1 class="main-h1 h2 color-text">{{ $category->title }}</h1>

		<div class="catalog">

			<div id="filters">
				<x-filters.filters 
					:filters="$filters" 
					:link="route('catalog', [$category->slug, ''], false)" 
					:minprice="$min_price" 
					:maxprice="$max_price" 
					:pricefrom="$pricefrom"
					:priceto="$priceto"
				/>
			</div>
			

			<div class="catalog-products">

				
				<div class="catalog-header">

					<div id="sort">
						<x-filters.sort :sort="$sort" />
					</div>

					<x-elements.filter-button :count="$count_filters" />

				</div>


				<div id="content-block">
					<x-products.products row="3" :products="$products"/>
				</div>

				<div id="pagination">
					<x-inc.pagination 
						:count="$count" 
						:pagesize="$pagesize" 
						:page="$page"
						:paglink="$paglink"
						showmore 
					/>
				</div>

			</div>
		</div>

	</div>
	

	<x-slot name="meta_title">
		{{ $category->meta_title }}
	</x-slot>
	
	<x-slot name="meta_description">
		{{ $category->meta_description }}
	</x-slot>
	
	<x-slot name="meta_keywords">
		{{ $category->meta_keywords }}
	</x-slot>
	

</x-layout>

