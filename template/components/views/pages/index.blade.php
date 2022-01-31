<x-layout>
	<?php //$s = new Single('Главная', 10, 1); ?>

	<h1>HW!</h1>

	<x-slot name="meta_title">
		{{-- {{ $s->field('Meta', 'Meta Title', 'textarea', true, 'DTG | Mainpage') }} --}}
	</x-slot>
	
	<x-slot name="meta_description">
		{{-- {{ $s->field('Meta', 'Meta Description', 'textarea', true, 'DTG | Mainpage') }} --}}
	</x-slot>
	
	<x-slot name="meta_keywords">
		{{-- {{ $s->field('Meta', 'Meta Keywords', 'textarea', true, 'DTG | Mainpage') }} --}}
	</x-slot>
	

</x-layout>