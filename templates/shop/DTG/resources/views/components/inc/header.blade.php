{{-- @if(Platform::desktop() && !Platform::tablet()) --}}

	<div class="first-header desktop">
		<div class="container">
			<div class="header-inner">
				<a href="{{ Lang::link('/') }}" class="header-logo-wrapper">
					<img src="/images/logo.svg" alt="" class="logo">
				</a>
				
				<form action="{{ Lang::link('/search') }}" class="search-form">
					<x-inputs.input class="search" name="s" placeholder="{{ $fields['search_text'] }}" type="text" autocomplete="off" />
					<svg class="search-icon" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M21.8657 20.5695L15.4749 14.1787C16.687 12.6822 17.4167 10.7797 17.4167 8.70836C17.4167 3.9066 13.5101 0 8.70832 0C3.90655 0 0 3.9066 0 8.70836C0 13.5101 3.9066 17.4167 8.70836 17.4167C10.7797 17.4167 12.6822 16.687 14.1787 15.4749L20.5695 21.8658C20.7486 22.0447 21.0387 22.0447 21.2178 21.8658L21.8658 21.2177C22.0447 21.0387 22.0447 20.7485 21.8657 20.5695ZM8.70836 15.5834C4.91727 15.5834 1.83335 12.4995 1.83335 8.70836C1.83335 4.91727 4.91727 1.83335 8.70836 1.83335C12.4995 1.83335 15.5834 4.91727 15.5834 8.70836C15.5834 12.4995 12.4995 15.5834 8.70836 15.5834Z" fill="#059F97"/>
					</svg>
					<div class="search-form-items">
						<div class="search-form-items-inner"></div>
						<div class="non-search-text extra-text color-text">{{ $fields['non_search_text'] }}</div>
					</div>
				</form>

				<div class="header-phones">
					@foreach ($fields['phones'] as $item)
						<a href="tel:{{ Field::phone($item[0]) }}" class="header-phone">
							<svg class="header-phone-icon" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M13.6189 10.2746L11.6652 8.32084C10.9674 7.62308 9.7812 7.90221 9.50209 8.80928C9.29276 9.43729 8.595 9.78617 7.96701 9.64659C6.57148 9.29771 4.68751 7.48352 4.33863 6.01822C4.1293 5.3902 4.54796 4.69244 5.17595 4.48314C6.08304 4.20403 6.36215 3.01783 5.66439 2.32007L3.71064 0.366326C3.15243 -0.122109 2.31511 -0.122109 1.82668 0.366326L0.500926 1.69208C-0.824828 3.08761 0.640479 6.78576 3.91997 10.0653C7.19947 13.3447 10.8976 14.8799 12.2932 13.4843L13.6189 12.1585C14.1074 11.6003 14.1074 10.763 13.6189 10.2746Z" fill="#059F97"/>
								<clipPath id="clip0_67_251">
									<rect width="14" height="14" fill="white"/>
								</clipPath>
							</svg>
							{{ $item[0] }}
						</a>
					@endforeach
				</div>

				<x-inputs.button type="empty" action="open_modal('callback', '{{ url()->current() }}')">
					{{ $fields['button_text'] }}
				</x-inputs.button>

				<div class="header-icons">

					<a 
						@if($is_user_login)
							href="{{ Lang::link('/user') }}" 					
						@else
							onclick="open_login_modal()" 
						@endif 
						class="header-icons-user-link"
					>
						<svg class="header-icons-user" width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M24.8995 19.1005C23.3747 17.5757 21.5597 16.4469 19.5795 15.7635C21.7004 14.3028 23.0938 11.8581 23.0938 9.09375C23.0938 4.63087 19.4629 1 15 1C10.5371 1 6.90625 4.63087 6.90625 9.09375C6.90625 11.8581 8.29963 14.3028 10.4206 15.7635C8.44034 16.4469 6.62538 17.5757 5.10052 19.1005C2.45627 21.7448 1 25.2605 1 29H3.1875C3.1875 22.4866 8.48655 17.1875 15 17.1875C21.5134 17.1875 26.8125 22.4866 26.8125 29H29C29 25.2605 27.5437 21.7448 24.8995 19.1005ZM15 15C11.7433 15 9.09375 12.3505 9.09375 9.09375C9.09375 5.837 11.7433 3.1875 15 3.1875C18.2567 3.1875 20.9062 5.837 20.9062 9.09375C20.9062 12.3505 18.2567 15 15 15Z" fill="#0F0F0F"/>
							<line x1="2" y1="28" x2="28" y2="28" stroke="#0F0F0F" stroke-width="2"/>
						</svg>	
					</a>

					<div onclick="open_cart_modal()" class="header-icons-buy-link">
						<div class="header-icons-circle">{{ $cartCount }}</div>
						<svg class="header-icons-buy" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M10.3101 20.6877H10.3115C10.3127 20.6877 10.314 20.6875 10.3152 20.6875H27.3125C27.731 20.6875 28.0989 20.4099 28.2139 20.0076L31.9639 6.88257C32.0447 6.59961 31.988 6.29541 31.811 6.06055C31.6338 5.82568 31.3567 5.6875 31.0625 5.6875H8.14795L7.47778 2.67163C7.38233 2.24268 7.00195 1.9375 6.5625 1.9375H0.9375C0.419678 1.9375 0 2.35718 0 2.875C0 3.39282 0.419678 3.8125 0.9375 3.8125H5.81055C5.9292 4.34692 9.01758 18.2449 9.19531 19.0444C8.19898 19.4775 7.5 20.4709 7.5 21.625C7.5 23.1758 8.76172 24.4375 10.3125 24.4375H27.3125C27.8303 24.4375 28.25 24.0178 28.25 23.5C28.25 22.9822 27.8303 22.5625 27.3125 22.5625H10.3125C9.79566 22.5625 9.375 22.1418 9.375 21.625C9.375 21.1089 9.79419 20.689 10.3101 20.6877V20.6877ZM29.8196 7.5625L26.6052 18.8125H11.0645L8.56445 7.5625H29.8196Z" fill="#0F0F0F"/>
							<path d="M9.375 27.25C9.375 28.8008 10.6367 30.0625 12.1875 30.0625C13.7383 30.0625 15 28.8008 15 27.25C15 25.6992 13.7383 24.4375 12.1875 24.4375C10.6367 24.4375 9.375 25.6992 9.375 27.25ZM12.1875 26.3125C12.7043 26.3125 13.125 26.7332 13.125 27.25C13.125 27.7668 12.7043 28.1875 12.1875 28.1875C11.6707 28.1875 11.25 27.7668 11.25 27.25C11.25 26.7332 11.6707 26.3125 12.1875 26.3125Z" fill="#0F0F0F"/>
							<path d="M22.625 27.25C22.625 28.8008 23.8867 30.0625 25.4375 30.0625C26.9883 30.0625 28.25 28.8008 28.25 27.25C28.25 25.6992 26.9883 24.4375 25.4375 24.4375C23.8867 24.4375 22.625 25.6992 22.625 27.25ZM25.4375 26.3125C25.9543 26.3125 26.375 26.7332 26.375 27.25C26.375 27.7668 25.9543 28.1875 25.4375 28.1875C24.9207 28.1875 24.5 27.7668 24.5 27.25C24.5 26.7332 24.9207 26.3125 25.4375 26.3125Z" fill="#0F0F0F"/>
						</svg>	
					</div>

				</div>

			</div>
		</div>
	</div>

	<header class="desktop">
		<div class="container">
			<div class="header-inner">
				
				<x-inc.menu />

				<div class="langs">
					@foreach (Lang::all() as $lang)
						<a href="{{ Lang::get_url($lang->tag) }}" class="lang @if($lang->tag == Lang::get()) active @endif">{{ $lang->tag }}</a>
					@endforeach
				</div>
			</div>
		</div>
	</header>

{{-- @else --}}

	<header class="mobile">
		<div class="header-wrapper">

			<div class="container">
				<div class="header-inner">
					<a href="{{ Lang::link('/') }}">
						<img src="/images/logo.svg" alt="" class="logo">
					</a>
					
					<form action="{{ Lang::link('/search') }}" class="search-form">
						<x-inputs.input class="search" name="s" placeholder="{{ $fields['search_text'] }}" type="text" autocomplete="off" />
						<svg class="search-icon" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M21.8657 20.5695L15.4749 14.1787C16.687 12.6822 17.4167 10.7797 17.4167 8.70836C17.4167 3.9066 13.5101 0 8.70832 0C3.90655 0 0 3.9066 0 8.70836C0 13.5101 3.9066 17.4167 8.70836 17.4167C10.7797 17.4167 12.6822 16.687 14.1787 15.4749L20.5695 21.8658C20.7486 22.0447 21.0387 22.0447 21.2178 21.8658L21.8658 21.2177C22.0447 21.0387 22.0447 20.7485 21.8657 20.5695ZM8.70836 15.5834C4.91727 15.5834 1.83335 12.4995 1.83335 8.70836C1.83335 4.91727 4.91727 1.83335 8.70836 1.83335C12.4995 1.83335 15.5834 4.91727 15.5834 8.70836C15.5834 12.4995 12.4995 15.5834 8.70836 15.5834Z" fill="#059F97"/>
						</svg>
						<svg class="search-clear" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M6.66295 6.00076L11.8627 0.800965C12.0458 0.617894 12.0458 0.321082 11.8627 0.138035C11.6796 -0.0450117 11.3828 -0.0450351 11.1998 0.138035L5.99999 5.33783L0.800231 0.138035C0.617161 -0.0450351 0.320349 -0.0450351 0.137302 0.138035C-0.0457441 0.321105 -0.0457675 0.617918 0.137302 0.800965L5.33707 6.00074L0.137302 11.2005C-0.0457675 11.3836 -0.0457675 11.6804 0.137302 11.8635C0.228826 11.955 0.348802 12.0007 0.468778 12.0007C0.588755 12.0007 0.708708 11.955 0.800254 11.8635L5.99999 6.66369L11.1998 11.8635C11.2913 11.955 11.4113 12.0007 11.5312 12.0007C11.6512 12.0007 11.7712 11.955 11.8627 11.8635C12.0458 11.6804 12.0458 11.3836 11.8627 11.2005L6.66295 6.00076Z" fill="#A0A0A0"/>
							<clipPath id="clip0_144_4005">
							<rect width="12" height="12" fill="white"/>
							</clipPath>
						</svg>
							
						<div class="search-form-items">
							<div class="search-form-items-inner"></div>
							<div class="non-search-text extra-text color-text">{{ $fields['non_search_text'] }}</div>
						</div>
					</form>
	
					<div class="header-icons">
						<div class="header-icons-search">
							<svg class="header-icons-search-open" width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M18.884 17.7646L13.3647 12.2452C14.4115 10.9528 15.0417 9.30976 15.0417 7.52086C15.0417 3.37388 11.6678 0 7.52082 0C3.37384 0 0 3.37388 0 7.52086C0 11.6678 3.37388 15.0417 7.52086 15.0417C9.30976 15.0417 10.9528 14.4115 12.2452 13.3647L17.7646 18.8841C17.9192 19.0386 18.1698 19.0386 18.3244 18.8841L18.8841 18.3244C19.0386 18.1698 19.0386 17.9192 18.884 17.7646ZM7.52086 13.4584C4.24673 13.4584 1.58335 10.795 1.58335 7.52086C1.58335 4.24673 4.24673 1.58335 7.52086 1.58335C10.795 1.58335 13.4584 4.24673 13.4584 7.52086C13.4584 10.795 10.795 13.4584 7.52086 13.4584Z" fill="#059F97"/>
							</svg>
						</div>

						<div onclick="open_cart_modal()" class="header-icons-buy-link">
							<div class="header-icons-circle">{{ $cartCount }}</div>
							<svg class="header-icons-buy" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M10.3101 20.6877H10.3115C10.3127 20.6877 10.314 20.6875 10.3152 20.6875H27.3125C27.731 20.6875 28.0989 20.4099 28.2139 20.0076L31.9639 6.88257C32.0447 6.59961 31.988 6.29541 31.811 6.06055C31.6338 5.82568 31.3567 5.6875 31.0625 5.6875H8.14795L7.47778 2.67163C7.38233 2.24268 7.00195 1.9375 6.5625 1.9375H0.9375C0.419678 1.9375 0 2.35718 0 2.875C0 3.39282 0.419678 3.8125 0.9375 3.8125H5.81055C5.9292 4.34692 9.01758 18.2449 9.19531 19.0444C8.19898 19.4775 7.5 20.4709 7.5 21.625C7.5 23.1758 8.76172 24.4375 10.3125 24.4375H27.3125C27.8303 24.4375 28.25 24.0178 28.25 23.5C28.25 22.9822 27.8303 22.5625 27.3125 22.5625H10.3125C9.79566 22.5625 9.375 22.1418 9.375 21.625C9.375 21.1089 9.79419 20.689 10.3101 20.6877V20.6877ZM29.8196 7.5625L26.6052 18.8125H11.0645L8.56445 7.5625H29.8196Z" fill="#0F0F0F"/>
								<path d="M9.375 27.25C9.375 28.8008 10.6367 30.0625 12.1875 30.0625C13.7383 30.0625 15 28.8008 15 27.25C15 25.6992 13.7383 24.4375 12.1875 24.4375C10.6367 24.4375 9.375 25.6992 9.375 27.25ZM12.1875 26.3125C12.7043 26.3125 13.125 26.7332 13.125 27.25C13.125 27.7668 12.7043 28.1875 12.1875 28.1875C11.6707 28.1875 11.25 27.7668 11.25 27.25C11.25 26.7332 11.6707 26.3125 12.1875 26.3125Z" fill="#0F0F0F"/>
								<path d="M22.625 27.25C22.625 28.8008 23.8867 30.0625 25.4375 30.0625C26.9883 30.0625 28.25 28.8008 28.25 27.25C28.25 25.6992 26.9883 24.4375 25.4375 24.4375C23.8867 24.4375 22.625 25.6992 22.625 27.25ZM25.4375 26.3125C25.9543 26.3125 26.375 26.7332 26.375 27.25C26.375 27.7668 25.9543 28.1875 25.4375 28.1875C24.9207 28.1875 24.5 27.7668 24.5 27.25C24.5 26.7332 24.9207 26.3125 25.4375 26.3125Z" fill="#0F0F0F"/>
							</svg>	
						</div>

						<div class="toggle-menu">
							<div class="toggle-menu-item"></div>
							<div class="toggle-menu-item"></div>
							<div class="toggle-menu-item"></div>
						</div>
					</div>
	
				</div>
			</div>
	
			<div class="mobile-menu" id="mobile-menu">
				
				<x-inc.menu />
	
				<div class="header-menu-langs-and-user">
					<div class="langs">
						@foreach (Lang::all() as $lang)
							<a href="{{ Lang::get_url($lang->tag) }}" class="lang @if($lang->tag == Lang::get()) active @endif">{{ $lang->tag }}</a>
						@endforeach
					</div>

					<a 
						@if($is_user_login)
							href="{{ Lang::link('/user') }}" 					
						@else
							onclick="open_login_modal()" 
						@endif 
						class="header-icons-user-link"
					>
						<svg class="header-icons-user" width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M19.0896 14.6437C17.9205 13.4747 16.529 12.6093 15.0109 12.0854C16.6369 10.9655 17.7051 9.0912 17.7051 6.97187C17.7051 3.55033 14.9215 0.766663 11.4999 0.766663C8.07839 0.766663 5.29473 3.55033 5.29473 6.97187C5.29473 9.0912 6.36299 10.9655 7.98904 12.0854C6.47086 12.6093 5.07939 13.4747 3.91034 14.6437C1.88308 16.671 0.766602 19.3664 0.766602 22.2333H2.44368C2.44368 17.2397 6.50629 13.1771 11.4999 13.1771C16.4936 13.1771 20.5562 17.2397 20.5562 22.2333H22.2333C22.2333 19.3664 21.1168 16.671 19.0896 14.6437ZM11.4999 11.5C9.00313 11.5 6.97181 9.46871 6.97181 6.97187C6.97181 4.47503 9.00313 2.44375 11.4999 2.44375C13.9967 2.44375 16.0281 4.47503 16.0281 6.97187C16.0281 9.46871 13.9967 11.5 11.4999 11.5Z" fill="#0F0F0F"/>
							<line x1="1.5332" y1="21.2333" x2="21.4665" y2="21.2333" stroke="#0F0F0F" stroke-width="2"/>
						</svg>
					</a>
				</div>
					
	
				<div class="header-phones">
					@foreach ($fields['phones'] as $item)
						<a href="tel:{{ Field::phone($item[0]) }}" class="header-phone">
							<svg class="header-phone-icon" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M13.6189 10.2746L11.6652 8.32084C10.9674 7.62308 9.7812 7.90221 9.50209 8.80928C9.29276 9.43729 8.595 9.78617 7.96701 9.64659C6.57148 9.29771 4.68751 7.48352 4.33863 6.01822C4.1293 5.3902 4.54796 4.69244 5.17595 4.48314C6.08304 4.20403 6.36215 3.01783 5.66439 2.32007L3.71064 0.366326C3.15243 -0.122109 2.31511 -0.122109 1.82668 0.366326L0.500926 1.69208C-0.824828 3.08761 0.640479 6.78576 3.91997 10.0653C7.19947 13.3447 10.8976 14.8799 12.2932 13.4843L13.6189 12.1585C14.1074 11.6003 14.1074 10.763 13.6189 10.2746Z" fill="#059F97"/>
								<clipPath id="clip0_67_251">
									<rect width="14" height="14" fill="white"/>
								</clipPath>
							</svg>
							{{ $item[0] }}
						</a>
					@endforeach
				</div>
	
				<x-inputs.button type="empty" action="open_modal('callback', '{{ url()->current() }}')">
					{{ $fields['button_text'] }}
				</x-inputs.button>
	
			</div>
		</div>
		

	</header>

{{-- @endif --}}

@desktopcss
<style>

	.first-header {
		padding: 20px 0;
		border-bottom: 1px solid var(--color-back-and-stroke);
		background: var(--color-white);
	}

	.header-logo-wrapper {
		flex-shrink: 0;
	}

	.logo {
		width: 130.46px;
		height: 56px;
	}

	.header-inner {
		display: flex;
		align-items: center;
		justify-content: space-between;
	}

	.search-form {
		position: relative;
		width: 414px;
		margin-left: 68px;
		margin-right: 68px;
		flex-shrink: 0;
	}

	.search-form-items{
		position: absolute;
		top: calc(100% + 5px);
		left: 0;
		width: 100%;
		background: #FFFFFF;
		box-shadow: 0px 4px 30px rgba(0, 0, 0, 0.07);
		border-radius: 5px;
		z-index: 1000;
		padding: 12px 20px;
		display: none;
	}

	.search-form-item {
		padding: 10px 0;
		border-bottom: 1px solid var(--color-back-and-stroke); 
	}
	
	.search-form-item:first-child{
		padding-top: 0;
	}

	.search-form-item:last-child{
		padding-bottom: 0;
		border: none;
	}

	.search-icon {
		position: absolute;
		top: 50%;
		right: 14px;
		transform: translateY(-50%);
		width: 22px;
		height: 22px;
		cursor: pointer;
	}

	.search-icon path{
		fill: var(--color-second);
	}

	.header-phones {
		margin-right: 25px;
		flex-shrink: 0;
	}

	.header-phone {
		font-style: normal;
		font-weight: normal;
		font-size: 18px;
		line-height: 28px;
		color: var(--color-text);
		display: flex;
		align-items:center;
		text-decoration: none;
		transition: .3s;
	}

	.header-phone:hover {
		color: var(--color-second);
	}

	.header-phone-icon {
		width: 14px;
		height: 14px;
		margin-right: 10px;
	}

	.header-phone-icon path {
		fill: var(--color-second);
	}

	header {
		background: var(--color-white);
		position: sticky;
		top: -1px;
		left: 0;
		z-index: 100;
		transition: .3s;
	}

	header.sticky {
		background: var(--color-second);
	}

	header.sticky .menu-item-wrapper a{
		color: var(--color-white);
	}

	header.sticky .submenu a {
		color: var(--color-text);
	}

	header.sticky .menu-item-wrapper-parent a:after{
		border-color: var(--color-white) !important;
	}

	header.sticky .submenu .menu-item-wrapper-parent a:after{
		border-color: var(--color-second) !important;
	}

	.menu-item-wrapper-parent {
		position: relative;
	}

	header.sticky .lang {
		color: #E7E7E7;
	}

	header.sticky .lang.active {
		color: var(--color-white);
	}

	.langs {
		display: flex;
		align-items: center;
	}

	.lang {
		font-style: normal;
		font-weight: normal;
		font-size: 16px;
		line-height: 28px;
		color: var(--color-grey);
		margin-right: 10px;
		text-transform: uppercase;
		transition: .3s
	}

	.lang:last-child {
		margin-right: 0;
	}

	.lang.active, 
	.lang:hover {
		text-decoration-line: underline;
		color: var(--color-text);
		font-weight: 450;
	}

	.non-search-text{
		display: none;
	}

	.header-icons {
		display: flex;
		margin-left: 56px;
	}

	.header-icons-user-link {
		width: 28px;
		height: 28px;
		margin-right: 17px;
		cursor: pointer;
	}

	.header-icons-user,
	.header-icons-buy {
		width: 28px;
		height: 28px;
	}

	.header-icons-buy-link {
		position: relative;
		width: 28px;
		height: 28px;
		cursor: pointer;
	}

	.header-icons-circle {
		background: var(--color-second);
		width: 22px;
		height: 22px;
		border-radius: 50%;
		position: absolute;
		top: -13px;
		right: -10px;
		font-style: normal;
		font-weight: normal;
		font-size: 14px;
		line-height: 19px;
		text-align: center;
		color: var(--color-white);
		display: flex;
		align-items: center;
		justify-content: center;
	}

</style>
@mobilecss
<style>
	
	.logo{
		width: 76px;
	}

	header {
		display: flex;
		width: 100%;
		position: sticky;
		top: -1px;
		left: 0;
		background: var(--color-white);
		z-index: 10000;
	}

	header .container {
		width: 100%;
	}

	.header-icons {
		display: flex;
		align-items: center;
	}

	.header-icons-search {
		margin-right: 20px;
	}

	.header-icons-search-open {
		width: 19px;
		height: 19px;
	}

	.search-form {
		position: absolute;
		top: 4px;
		left: var(--offset);
		width: 290px;
		flex-shrink: 0;
		z-index: 1000;
		display: none;
	}

	.search-form input {
		height: 38px;
		padding-left: 44px;
	}

	.search-form-items{
		position: absolute;
		top: calc(100% + 5px);
		left: 0;
		width: 100%;
		background: #FFFFFF;
		box-shadow: 0px 4px 30px rgba(0, 0, 0, 0.07);
		border-radius: 5px;
		z-index: 1000;
		padding: 10px 20px;
		display: none;
	}

	.search-form-item {
		padding: 10px 0;
		border-bottom: 1px solid var(--color-back-and-stroke); 
	}
	
	.search-form-item:first-child{
		padding-top: 0;
	}

	.search-form-item:last-child{
		padding-bottom: 0;
		border: none;
	}

	.search-icon {
		position: absolute;
		top: 50%;
		left: 10px;
		transform: translateY(-50%);
		width: 19px;
		height: 19px;
	}

	.search-icon path{
		fill: var(--color-second);
	}

	.search-clear {
		width: 12px;
		height: 12px;
		position: absolute;
		top: 50%;
		right: 12px;
		transform: translateY(-50%);
	}

	.first-header {
		display: none;
	}

	.header-inner{
		display: flex;
		align-items: center;
		justify-content: space-between;
		width: 100%;
		padding: 7px 0;
	}

	:root {
		--app-height: 100%;
	}

	.header-wrapper {
		overflow: auto;
		max-height: 100vh;
		width: 100%;
		max-height: var(--app-height);
	}

	header.active .header-wrapper{
		min-height: 100vh;
		background: var(--color-white);
		height: var(--app-height);
	}

	.header-wrapper::-webkit-scrollbar{
		display: none;
	}

	.header-wrapper.active {
		height: var(--app-height);
	}

	header.active .toggle-menu {
		transform: translateX(8px);
	}

	.toggle-menu{
		width: 30px;
		height: 30px;
		display: flex;
		flex-direction: column;
		align-items: flex-end;
		justify-content: center;
		position: relative;
		transition: .3s;
	}

	.toggle-menu-item{
		display: block;
		width: 30px;
		height: 2px;
		background: var(--color-second);
		margin: 3.5px 0;
		transition: .3s;
		opacity: 1;
	}

	header.active .toggle-menu-item{
		width: 25px;
	}

	header.active .toggle-menu-item:nth-child(2){
		opacity: 0;
	}

	header.active .toggle-menu-item:nth-child(1){
		transform: rotate(45deg);
		transform-origin: left top;
	}

	header.active .toggle-menu-item:nth-child(3){
		transform: rotate(-45deg);
		transform-origin: left bottom;
	}

	.mobile-menu {
		display: none;
		flex-direction: column;
		align-items: flex-start;
		/* position: absolute;
        top: calc(100% - 1px);
        left: 0; */
		position: relative;
        background: var(--color-white);
        width: 100%;
        padding: 0 var(--offset) 40px;
	}

	header.active .mobile-menu{
		display: flex;
	}

	.langs {
		display: flex;
		align-items: center;
	}

	.lang {
		font-style: normal;
		font-weight: normal;
		font-size: 16px;
		line-height: 28px;
		color: var(--color-grey);
		margin-right: 10px;
		text-transform: uppercase;
		transition: .3s
	}

	.lang:last-child {
		margin-right: 0;
	}

	.lang.active {
		text-decoration-line: underline;
		color: var(--color-text);
		font-weight: 450;
	}

	.header-menu-langs-and-user {
		display: flex;
		align-items: center;
		margin-bottom: 30px;
	}

	.header-icons-user-link {
		display: block;
		margin-left: 25px;
		padding-left: 25px;
		border-left: 1px solid var(--color-back-and-stroke); 
	}

	.header-icons-user {
		width: 23px;
		height: 23px;
	}

	.header-phones {
		margin-right: 25px;
		flex-shrink: 0;
		margin-bottom: 20px;
	}

	.header-phone {
		font-style: normal;
		font-weight: normal;
		font-size: 18px;
		line-height: 28px;
		color: var(--color-text);
		display: flex;
		align-items:center;
		text-decoration: none;
		transition: .3s;
	}

	.header-phone-icon {
		width: 14px;
		height: 14px;
		margin-right: 10px;
	}
	
	.header-phone-icon path {
		fill: var(--color-second);
	}

	.header-icons-buy {
		width: 26px;
		height: 26px;
	}

	.header-icons-buy-link {
		position: relative;
		width: 26px;
		height: 26px;
		cursor: pointer;
		margin-right: 18px;
	}

	.header-icons-circle {
		background: var(--color-second);
		width: 18px;
		height: 18px;
		border-radius: 50%;
		position: absolute;
		top: -5px;
		right: -6px;
		font-style: normal;
		font-weight: normal;
		font-size: 12px;
		line-height: 16px;
		text-align: center;
		color: var(--color-white);
		display: flex;
		align-items: center;
		justify-content: center;
	}
	
</style>
@endcss

@js
<script>
	
	$('.search-icon').on('click', function(){
		$(this).parent('form').el[0].submit();
	})

	$('.header-icons-search').on('click', function(){
		$('.search-form').css('display', 'block')
	})

	$('.search-clear').on('click', function(){
		$('.search-form').css('display', 'none')
	})

	$('.input-search').on('input', async function(){
		value = $(this).val()

		

		const response = await post(lang + '/api/search', {value: value}, false, false)

		if (response.success){
			$('.search-form-items').css('display', 'block')
			if (response.data.html){
				$('.non-search-text').css('display', 'none')
				$('.search-form-items-inner').css('display', 'block')
				$('.search-form-items-inner').html(response.data.html)
			} else {
				$('.search-form-items-inner').css('display', 'none')
				$('.non-search-text').css('display', 'block')
			} 

		} else {

		}

		if (!value){
			$('.search-form-items').css('display', 'none')
		}

	})

	$(document).on('mouseup', function (e) {
		var container = $('.search-form-items');
		if (!container.el[0].contains(e.target)){
			container.css('display', 'none');
		}
	});

	$('.toggle-menu').on('click', function(){
		$('header').toggleClass('active')
		$('body').toggleClass('blocked')
		// $('.header-wrapper').css('height', 'calc(' + $('header .container').height() + 'px + ' + $('#mobile-menu').height() + 'px)')
		$('.header-wrapper').toggleClass('active')

	})

	const appHeight = () => {
		const doc = document.documentElement
		doc.style.setProperty('--app-height', `${window.innerHeight}px`)
	}
	window.addEventListener('resize', appHeight)
	appHeight()

	const stickyElm = document.querySelector('header')

	const observer = new IntersectionObserver( 
		([e]) => e.target.classList.toggle('sticky', e.intersectionRatio < 1),
		{threshold: [1]}
	);

	observer.observe(stickyElm)

</script>
@endjs
