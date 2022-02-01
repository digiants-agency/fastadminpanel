<x-layout>

	<?php $s = new Single('Оформление заказа', 10, 4); ?>


	<x-inc.breadcrumbs :breadcrumbs="
		$breadcrumbs = [
			[
				'link'	=> '',
				'title'	=> $s->field('Оформление заказа', 'Заголовок', 'text', true, 'Оформление заказа'),
			]
		]
	"/>

	<div class="container mb-100">
		
		<div class="checkout-inner">
			<div class="checkout-info">
				<h1 class="main-h1 h2 color-text">{{ $s->field('Оформление заказа', 'Заголовок', 'text', true, 'Оформление заказа') }}</h1>

				<form class="checkout-form" id="checkout-form">

					<x-checkout.checkout-personal />

					<x-checkout.checkout-delivery />

					<x-checkout.checkout-type-delivery />

					<x-checkout.checkout-payment />
	
					<x-inputs.checkbox name="recall" value="1">
						{{ $s->field('Форма', 'Звонок', 'text', true, 'Мне можно не звонить для подтверждения заказа') }}
					</x-inputs.checkbox>

					<x-inputs.checkbox name="privacy" required>
						{!! $s->field('Форма', 'Условия использования', 'ckeditor', true, 'Я принимаю Условия использования и Политику конфиденциальности') !!}
					</x-inputs.checkbox>

					@if(!empty($total))
						<x-inputs.button id="checkout-submit" type="submit" style="display: none;">
							{{ $s->field('Форма', 'Кнопка', 'text', true, 'Подтвердить') }}
						</x-inputs.button>
					@else
						<x-inputs.button id="checkout-submit" type="submit">
							{{ $s->field('Форма', 'Кнопка', 'text', true, 'Подтвердить') }}
						</x-inputs.button>
					@endif

				</form>

			</div>

			<div class="checkout-cart" id="checkout-cart">
				<x-cart.cart />
			</div>

		</div>
		


	</div>

	<x-slot name="meta_title">
		{{ $s->field('Meta', 'Meta Title', 'textarea', true, 'DTG | Оформление заказа') }}
	</x-slot>
	
	<x-slot name="meta_description">
		{{ $s->field('Meta', 'Meta Description', 'textarea', true, 'DTG | Оформление заказа') }}
	</x-slot>
	
	<x-slot name="meta_keywords">
		{{ $s->field('Meta', 'Meta Keywords', 'textarea', true, 'DTG | Оформление заказа') }}
	</x-slot>
	

</x-layout>


@desktopcss
<style>

	.checkout-inner {
		display: flex;
		align-items: flex-start;
		justify-content: space-between;
	}

	.checkout-cart {
		width: 610px;
	}

	.checkout-info {
		width: 480px;
	}

	.checkout-block-title {
        margin-bottom: 12px;
    }
    
    .checkout-input-label {
        display: block;
        margin-bottom: 5px;
    }

    .checkout-block input {
        margin-bottom: 12px;
    }

    .checkout-block {
        margin-bottom: 30px;
    }

	.checkout-form .containercheckbox {
		margin-bottom: 16px;
		padding-left: 34px;
	}

	.checkout-form .containercheckbox .checkmark {
		right: auto;
		left: 0;
	}

	.checkout-form .containercheckbox p {
		display: inline;
	}

	.checkout-form .containercheckbox p a {
		display: inline;
		color: var(--color-second);
		text-decoration: underline;
	}

	.checkout-form .btn-submit {
		width: 200px;
	}

</style>
@mobilecss
<style>

	.checkout-inner {
		display: flex;
		flex-direction: column-reverse;
	}

	.checkout-block-title {
        margin-bottom: 12px;
    }

	.checkout-info {
		margin-top: 30px;
	}

	.checkout-info .main-h1 {
		margin-bottom: 15px; 
	}
    
    .checkout-input-label {
        display: block;
        margin-bottom: 5px;
    }

    .checkout-block input {
        margin-bottom: 12px;
    }

    .checkout-block {
        margin-bottom: 25px;
    }

	.checkout-form .containercheckbox {
		margin-bottom: 16px;
		padding-left: 28px;

		font-style: normal;
		font-weight: normal;
		font-size: 12px;
		line-height: 20px;
	}

	.checkout-form .containercheckbox .checkmark {
		right: auto;
		left: 0;
		width: 18px;
		height: 18px;
	}

	.checkout-form .containercheckbox p {
		display: inline;
	}

	.checkout-form .containercheckbox p a {
		display: inline;
		color: var(--color-second);
		text-decoration: underline;
	}

	.checkout-form .btn-submit {
		width: 160px;
	}

</style>
@endcss

