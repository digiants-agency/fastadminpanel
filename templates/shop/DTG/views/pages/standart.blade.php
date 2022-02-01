<x-layout>

	<x-inc.breadcrumbs :breadcrumbs="
		$breadcrumbs = [
			[
				'link'	=> '',
				'title'	=> $page->title,
			]
		]
	"/>

	<div class="container mb-100">
		<h1 class="main-h1 h2 color-text">{{ $page->title }}</h1>
		<x-inc.content>
			{!! $page->content !!}
		</x-inc.content>
	</div>

	<x-slot name="meta_title">
		{{ $page->meta_title }}
	</x-slot>
	
	<x-slot name="meta_description">
		{{ $page->meta_description }}
	</x-slot>
	
	<x-slot name="meta_keywords">
		{{ $page->meta_keywords }}
	</x-slot>
	

</x-layout>
