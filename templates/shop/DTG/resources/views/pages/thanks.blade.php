<x-layout>

	<?php $s = new Single('Спасибо за заказ', 10, 1); ?>

	<x-inc.breadcrumbs :breadcrumbs="
		$breadcrumbs = [
			[
				'link'	=> '',
				'title'	=> $s->field('Спасибо за заказ', 'Заголовок', 'text', true, 'Спасибо за заказ'),
			]
		]
	"/>

	<div class="thanks mb-100">
		<div class="container">
			<div class="thanks-inner">

				<div class="h1 color-text thanks-title">{{ $s->field('Спасибо за заказ', 'Заголовок', 'text', true, 'Спасибо за заказ') }}</div>
				<div class="main-text color-text thanks-desc">{{ $s->field('Спасибо за заказ', 'Текст', 'text', true, 'Ваш заказ успешно оформлен. Мы свяжемся с вами в ближайшее время.') }}</div>

				<x-inputs.button href="{{ Lang::link($s->field('Спасибо за заказ', 'Кнопка (ссылка)', 'text', true, '/')) }}" type="center">
					{{ $s->field('Спасибо за заказ', 'Кнопка (текст)', 'text', true, 'На главную') }}
				</x-inputs.button>
			</div>
		</div>
	</div>

	<x-slot name="meta_title">
		{{ $s->field('Meta', 'Meta Title', 'textarea', true, 'DTG | Спасибо за заказ') }}
	</x-slot>
	
	<x-slot name="meta_description">
		{{ $s->field('Meta', 'Meta Description', 'textarea', true, 'DTG | Спасибо за заказ') }}
	</x-slot>
	
	<x-slot name="meta_keywords">
		{{ $s->field('Meta', 'Meta Keywords', 'textarea', true, 'DTG | Спасибо за заказ') }}
	</x-slot>
	

</x-layout>

@desktopcss
<style>

	.thanks-inner {
		display: flex;
		align-items: center;
		flex-direction: column;
		padding-top: 20px;
	}

	.thanks-title {
		margin-bottom: 15px;
	}

	.thanks-desc {
		margin-bottom: 30px;
		text-align: center;
	}

</style>
@mobilecss
<style>

	.thanks-inner {
		display: flex;
		align-items: center;
		flex-direction: column;
		padding-top: 20px;
	}

	.thanks-title {
		margin-bottom: 15px;
	}

	.thanks-desc {
		margin-bottom: 30px;
		text-align: center;
	}

</style>
@endcss