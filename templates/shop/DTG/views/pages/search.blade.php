<x-layout>

	<?php $s = new Single('Поиск', 10, 1); ?>

	<x-inc.breadcrumbs :breadcrumbs="
		$breadcrumbs = [
			[
				'link'	=> '',
				'title'	=> $s->field('Поиск', 'Заголовок', 'text', true, 'Результаты поиска по запросу').' ”'.$value.'”',
			]
		]
	"/>

	<div class="container mb-100">
		
		<h1 class="main-h1 h2 color-text">
			{{ $s->field('Поиск', 'Заголовок', 'text', true, 'Результаты поиска по запросу') }} “{{ $value }}”
		</h1>

		@if(!empty($products))
			<div id="content-block">
				<x-products.products row="4" :products="$products" />
			</div>
		@else
			<div class="h4 color-text">
				{{ $s->field('Поиск', 'Пустой запрос', 'text', true, 'Ничего не найдено. Введите свой запрос') }}
			</div>
		@endif

		<div id="pagination">
			<x-inc.pagination 
				:count="$count" 
				:pagesize="$pagesize" 
				:page="$page"
				:paglink="$paglink" 
			/>
		</div>
		
	</div>

	<x-slot name="meta_title">
		{{ $s->field('Meta', 'Meta Title', 'textarea', true, 'DTG | Search') }}
	</x-slot>
	
	<x-slot name="meta_description">
		{{ $s->field('Meta', 'Meta Description', 'textarea', true, 'DTG | Search') }}
	</x-slot>
	
	<x-slot name="meta_keywords">
		{{ $s->field('Meta', 'Meta Keywords', 'textarea', true, 'DTG | Search') }}
	</x-slot>
	

</x-layout>
