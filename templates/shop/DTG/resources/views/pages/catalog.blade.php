<x-layout>
	<?php $s = new Single('Каталог', 10, 1); ?>

	<x-inc.breadcrumbs :breadcrumbs="
		$breadcrumbs = [
			[
				'link'	=> '',
				'title'	=> $s->field('Категории', 'Заголовок', 'text', true, 'Каталог товаров'),
			]
		]
	"/>


	<x-categories.categories page>

	</x-categories.categories>

	<x-inc.horizontal />

	<x-slot name="meta_title">
		{{ $s->field('Meta', 'Meta Title', 'textarea', true, 'DTG | Catalog') }}
	</x-slot>
	
	<x-slot name="meta_description">
		{{ $s->field('Meta', 'Meta Description', 'textarea', true, 'DTG | Catalog') }}
	</x-slot>
	
	<x-slot name="meta_keywords">
		{{ $s->field('Meta', 'Meta Keywords', 'textarea', true, 'DTG | Catalog') }}
	</x-slot>
	

</x-layout>
