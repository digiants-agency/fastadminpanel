<x-layout>

	<?php $s = new Single('Блог', 10, 1); ?>

	<x-inc.breadcrumbs :breadcrumbs="
		$breadcrumbs = [
			[
				'link'	=> route('blog', '', false),
				'title'	=> $s->field('Блог', 'Заголовок', 'textarea', true, 'Статьи'),
			],
			[
				'link'	=> '',
				'title'	=> $article->title,
			]
		]
	"/>

	<x-blog.article-page :article="$article" />

	<x-blog.blog :articles="$read_more" >
		
		<x-slot name="title">
			{{ $s->field('Страница статьи', 'Заголовок "Читайте также"', 'textarea', true, 'Читайте также') }}
		</x-slot>

	</x-blog.blog>


	<x-slot name="meta_title">
		{{ $article->meta_title }}
	</x-slot>
	
	<x-slot name="meta_description">
		{{ $article->meta_description }}
	</x-slot>
	
	<x-slot name="meta_keywords">
		{{ $article->meta_keywords }}
	</x-slot>
	

</x-layout>
