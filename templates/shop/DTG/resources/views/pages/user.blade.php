<x-layout>

	<?php $s = new Single('Личный кабинет', 10, 1); ?>


	<x-inc.breadcrumbs :breadcrumbs="
		$breadcrumbs = [
			[
				'link'	=> '',
				'title'	=> $s->field('Личный кабинет', 'Заголовок', 'text', true, 'Личный кабинет'),
			]
		]
	"/>

	<div class="container mb-100">
		
		<div class="user-header">
			<h1 class="main-h1 h2 color-text">{{ $s->field('Личный кабинет', 'Заголовок', 'text', true, 'Личный кабинет') }}</h1>
			<div class="color-grey user-logout" onclick="user_logout()">
				<svg class="user-logout-svg" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M12.532 14.5232H14.0938V17.6465C14.0938 18.9381 13.0429 19.9889 11.7513 19.9889H2.34238C1.05087 19.9889 0 18.9381 0 17.6465V2.34238C0 1.05087 1.05087 0 2.34238 0H11.7513C13.0429 0 14.0938 1.05087 14.0938 2.34238V5.4657H12.532V2.34238C12.532 1.91193 12.1819 1.56158 11.7513 1.56158H2.34238C1.91193 1.56158 1.56158 1.91193 1.56158 2.34238V17.6465C1.56158 18.0769 1.91193 18.4273 2.34238 18.4273H11.7513C12.1819 18.4273 12.532 18.0769 12.532 17.6465V14.5232ZM16.3191 6.31348L15.2148 7.41776L17.0107 9.21371H6.91025V10.7753H17.0107L15.2148 12.5711L16.3191 13.6754L20 9.99451L16.3191 6.31348Z" fill="#A0A0A0"/>
					<clipPath id="clip0_284_12190">
						<rect width="20" height="20" fill="white"/>
					</clipPath>
				</svg>
				{{ $s->field('Личный кабинет', 'Выйти из кабинета', 'text', true, 'Выйти из кабинета') }}
			</div>
		</div>

		<div class="user-inner">
			
			<div id="user-navigation">
				<x-user.user-navigation :route="$route" />
			</div>

			<div id="user-content" class="desktop">

				@if($route == 'user') 
					<x-user.user-info active />
				@else
					<x-user.user-info />
				@endif
				
				@if($route == 'userhistory')
					<x-user.user-history active />
				@else
					<x-user.user-history />
				@endif
			
				@if($route == 'userwished')
					<x-user.user-wished active />
				@else
					<x-user.user-wished />
				@endif


			</div>
			
		</div>
	

	</div>

	<x-slot name="meta_title">
		{{ $s->field('Meta', 'Meta Title', 'textarea', true, 'DTG | Личный кабинет') }}
	</x-slot>
	
	<x-slot name="meta_description">
		{{ $s->field('Meta', 'Meta Description', 'textarea', true, 'DTG | Личный кабинет') }}
	</x-slot>
	
	<x-slot name="meta_keywords">
		{{ $s->field('Meta', 'Meta Keywords', 'textarea', true, 'DTG | Личный кабинет') }}
	</x-slot>
	

</x-layout>


@desktopcss
<style>

	.user-header {
		display: flex;
		align-items: center;
		justify-content: space-between;
		width: 100%;
	}

	.user-logout {
		display: flex;
		align-items: center;
		font-style: normal;
		font-weight: normal;
		font-size: 14px;
		line-height: 24px;
		cursor: pointer;
	}

	.user-logout-svg {
		width: 20px;
		height: 20px;
		margin-right: 10px;
	}

	.user-inner {
		display: flex;
		align-items: flex-start;
	}

	.user-content {
		padding-left: 120px;
		padding-top: 20px;
		display: none;
	}

	.user-content.active {
		display: block;
	}

</style>
@mobilecss
<style>

	.user-header {
		margin-bottom: 10px; 
	}

	.user-logout {
		display: flex;
		align-items: center;
		font-style: normal;
		font-weight: normal;
		font-size: 14px;
		line-height: 24px;
		cursor: pointer;
		text-decoration: underline;
	}

	.user-logout-svg {
		width: 20px;
		height: 20px;
		margin-right: 10px;
	}

	.user-content {
		display: none;
	}

	.user-content.active {
		display: block;
	}

	.user-content.active .user-info-title,
	.user-content.active .user-history-title,
	.user-content.active .user-wished-title {
		display: none;
	}

</style>
@endcss
