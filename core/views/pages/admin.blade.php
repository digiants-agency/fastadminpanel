<template id="admin">
	<div class="admin">
		@if(Platform::mobile())
			<div class="topbar">
				<div class="toggle" :class="{ active: showMobileMenu }" v-on:click="showMobileMenu = !showMobileMenu">
					<div class="toggle-item"></div>
					<div class="toggle-item"></div>
					<div class="toggle-item"></div>
				</div>
				<div class="sidebar-header">
					<a href="/" target="_blank">
						<img src="/vendor/fastadminpanel/images/logo.svg" alt="" class="sidebar-logo">
					</a>
					<router-link :to="{name: 'home'}" class="sidebar-header-title">{{ __('fastadminpanel.admin_panel') }}</router-link>
				</div>
			</div>
		@endif

		<main>
			<sidebar :class="{ active: showMobileMenu }"></sidebar>
			<div class="content">
				<router-view></router-view>
			</div>
		</main>
	</div>
</template>

<script>
const adminPage = {
	template: '#admin',
	props: [],
	data() {
		return {
			showMobileMenu: false,
		}
	},
	methods: {
	},
}
</script>