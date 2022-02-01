<x-layout>

	<?php $s = new Single('О компании', 10, 1); ?>

	<x-inc.breadcrumbs :breadcrumbs="
		$breadcrumbs = [
			[
				'link'	=> '',
				'title'	=> $s->field('О компании', 'Заголовок', 'text', true, 'О компании'),
			]
		]
	"/>

	<div class="container mb-100">
		<h1 class="main-h1 h2 color-text">{{ $s->field('О компании', 'Заголовок', 'text', true, 'О компании') }}</h1>

		<x-inc.content>
			{!! $s->field('О компании', 'Контент', 'ckeditor', true, '') !!}
		</x-inc.content>

	</div>
	
	<x-about.advantages />

	<x-inc.text-block type="about">
		<x-slot name="content">
			<x-inc.content>
				{!! $s->field('Наша история', 'Контент', 'ckeditor', true, '') !!}
			</x-inc.content>
		</x-slot>

		<x-slot name="image">{!! $s->field('Наша история', 'Изображение {537x482}', 'photo', true, '/images/about2.png') !!}</x-slot>
	</x-inc.text-block>


	<x-slot name="meta_title">
		{{ $s->field('Meta', 'Meta Title', 'textarea', true, 'DTG | About') }}
	</x-slot>
	
	<x-slot name="meta_description">
		{{ $s->field('Meta', 'Meta Description', 'textarea', true, 'DTG | About') }}
	</x-slot>
	
	<x-slot name="meta_keywords">
		{{ $s->field('Meta', 'Meta Keywords', 'textarea', true, 'DTG | About') }}
	</x-slot>
	

</x-layout>
