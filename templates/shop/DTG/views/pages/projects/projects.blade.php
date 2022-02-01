<x-layout>

	<?php $s = new Single('Проекты', 10, 1); ?>

	<x-inc.breadcrumbs :breadcrumbs="
		$breadcrumbs = [
			[
				'link'	=> '',
				'title'	=> $s->field('Проекты', 'Заголовок', 'text', true, 'Наши последние проекты'),
			]
		]
	"/>

	<div id="content-block">
		<x-projects.projects :projects="$projects" />
	</div>

	<div id="pagination">

		<x-inc.pagination 
		:count="$count" 
		:pagesize="$pagesize" 
		:page="$page"
		:paglink="$paglink" />

	</div>

	<x-inc.horizontal />

	<x-slot name="meta_title">
		{{ $s->field('Meta', 'Meta Title', 'textarea', true, 'DTG | Projects') }}
	</x-slot>
	
	<x-slot name="meta_description">
		{{ $s->field('Meta', 'Meta Description', 'textarea', true, 'DTG | Projects') }}
	</x-slot>
	
	<x-slot name="meta_keywords">
		{{ $s->field('Meta', 'Meta Keywords', 'textarea', true, 'DTG | Projects') }}
	</x-slot>
	

</x-layout>
