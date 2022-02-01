<x-layout>

	<?php $s = new Single('Контакты', 10, 1); ?>


	<x-inc.breadcrumbs type="mb-0" :breadcrumbs="
		$breadcrumbs = [
			[
				'link'	=> '',
				'title'	=> $s->field('Контакты', 'Заголовок', 'text', true, 'Контакты'),
			]
		]
	"/>

	<x-contacts.contacts />	

	<x-slot name="meta_title">
		{{ $s->field('Meta', 'Meta Title', 'textarea', true, 'DTG | Contacts') }}
	</x-slot>
	
	<x-slot name="meta_description">
		{{ $s->field('Meta', 'Meta Description', 'textarea', true, 'DTG | Contacts') }}
	</x-slot>
	
	<x-slot name="meta_keywords">
		{{ $s->field('Meta', 'Meta Keywords', 'textarea', true, 'DTG | Contacts') }}
	</x-slot>
	

</x-layout>
