<x-layout>

	<?php $s = new Single('Проекты', 10, 1); ?>

	<x-inc.breadcrumbs :breadcrumbs="
		$breadcrumbs = [
			[
				'link'	=> route('projects', '', false),
				'title'	=> $s->field('Проекты', 'Заголовок', 'text', true, 'Наши последние проекты'),
			],
			[
				'link'	=> '',
				'title'	=> $project->title
			]
		]
	"/>

	<div class="container project-inner mb-100">
		<h1 class="main-h1 h2 color-text">{{ $project->title }}</h1>

		<x-sliders.slider-project :images="$project->gallery" />

		<x-inc.content>
			{!! $project->content !!}
		</x-inc.content>

		<x-inputs.button type="project" action="open_modal('callback')">
			{{ $s->field('Страница проекта', 'Кнопка (текст)', 'text', true, 'Заказать дизайн') }}
		</x-inputs.button>
	</div>

	<x-slot name="meta_title">
		{{ $project->meta_title }}
	</x-slot>
	
	<x-slot name="meta_description">
		{{ $project->meta_description }}
	</x-slot>
	
	<x-slot name="meta_keywords">
		{{ $project->meta_keywords }}
	</x-slot>
	

</x-layout>