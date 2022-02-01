<x-layout>
	<?php $s = new Single('Блог', 10, 1); ?>

	<x-inc.breadcrumbs :breadcrumbs="
		$breadcrumbs = [
			[
				'link'	=> '',
				'title'	=> $s->field('Блог', 'Заголовок', 'textarea', true, 'Статьи'),
			]
		]
	"/>

	<div id="content-block">
		<x-blog.blog :articles="$articles" />
	</div>

	<div id="pagination">
		<x-inc.pagination 
		:count="$count" 
		:pagesize="$pagesize" 
		:page="$page"
		:paglink="$paglink" />
	</div>

	<x-slot name="meta_title">
		{{ $s->field('Meta', 'Meta Title', 'textarea', true, 'DTG | Blog') }}
	</x-slot>
	
	<x-slot name="meta_description">
		{{ $s->field('Meta', 'Meta Description', 'textarea', true, 'DTG | Blog') }}
	</x-slot>
	
	<x-slot name="meta_keywords">
		{{ $s->field('Meta', 'Meta Keywords', 'textarea', true, 'DTG | Blog') }}
	</x-slot>
	

</x-layout>
