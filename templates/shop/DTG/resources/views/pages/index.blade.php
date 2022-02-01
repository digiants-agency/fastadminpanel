<x-layout>
	<?php $s = new Single('Главная', 10, 1); ?>

	<x-inc.seo>
		<x-slot name="title">
			{{ $s->field('SEO text', 'Заголовок', 'text', true, 'Seo Text') }}
		</x-slot>

		<x-slot name="content">
			{!! $s->field('SEO text', 'Контент', 'ckeditor', true, '') !!}
		</x-slot>

	</x-inc.seo>
	
	<x-index.banner />

	<x-inc.horizontal />

	<x-categories.categories button />

	<x-index.horizontal-banner />

	<x-projects.projects button :projects="$projects" />

	<x-inc.text-block>


		<x-slot name="content">
			<x-inc.content>
				{!! $s->field('Текстовый блок', 'Текст', 'ckeditor', true, '') !!}
			</x-inc.content>
		</x-slot>

		<x-slot name="button">
			<x-inputs.button href="{{ Lang::link($s->field('Текстовый блок', 'Кнопка (ссылка)', 'text', false, '/about')) }}">
				{{ $s->field('Текстовый блок', 'Кнопка (текст)', 'text', true, 'Поброднее') }}
			</x-inputs.button>
		</x-slot>

		<x-slot name="image">{{ $s->field('Текстовый блок', 'Изображение {612x662}', 'photo', false, '/images/text-block.png') }}</x-slot>

	</x-inc.text-block>
		

	<x-blog.blog index :articles="$blog" />
		
	<x-inc.horizontal />

	<x-slot name="meta_title">
		{{ $s->field('Meta', 'Meta Title', 'textarea', true, 'DTG | Mainpage') }}
	</x-slot>
	
	<x-slot name="meta_description">
		{{ $s->field('Meta', 'Meta Description', 'textarea', true, 'DTG | Mainpage') }}
	</x-slot>
	
	<x-slot name="meta_keywords">
		{{ $s->field('Meta', 'Meta Keywords', 'textarea', true, 'DTG | Mainpage') }}
	</x-slot>
	

</x-layout>