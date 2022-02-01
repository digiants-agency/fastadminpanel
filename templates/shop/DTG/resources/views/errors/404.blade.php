<x-layout>

	<?php $s = new Single('404', 10, 1); ?>

	<x-inc.breadcrumbs :breadcrumbs="
		$breadcrumbs = [
			[
				'link'	=> '',
				'title'	=> $s->field('404', 'Название', 'text', true, '404'),
			]
		]
	"/>

    {{-- <x-errors.error404 /> --}}
	<div class="error-404 mb-100">
		<div class="container">
			<div class="error-404-inner">
				<img srcset="/images/lazy.svg" src="{{ $s->field('404', 'Изображение {564x315}', 'photo', false, '/images/404.png') }}" alt="" class="error-404-image">
				<div class="h2 color-text error-404-title">{{ $s->field('404', 'Текст', 'text', true, 'Извините, страница не найдена') }}</div>
				<x-inputs.button href="{{ Lang::link($s->field('404', 'Кнопка (ссылка)', 'text', true, '/')) }}" type="center">
					{{ $s->field('404', 'Кнопка (текст)', 'text', true, 'На главную') }}
				</x-inputs.button>
			</div>
		</div>
	</div>

	<x-slot name="meta_title">
		{{ $s->field('Meta', 'Meta Title', 'textarea', true, 'DTG | 404') }}
	</x-slot>
	
	<x-slot name="meta_description">
		{{ $s->field('Meta', 'Meta Description', 'textarea', true, 'DTG | 404') }}
	</x-slot>
	
	<x-slot name="meta_keywords">
		{{ $s->field('Meta', 'Meta Keywords', 'textarea', true, 'DTG | 404') }}
	</x-slot>
	

</x-layout>
