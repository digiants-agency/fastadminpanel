<template id="not-found">
	<main class="login-form">
		<div class="login-form-fields">
			<div class="login-form-logo-wrapper">
				<a href="/">
					<img src="/vendor/fastadminpanel/images/logo.svg" alt="" class="login-form-logo">
				</a>
				<div class="login-title">Not found</div>
			</div>
			<div class="login-form-title">404</div>
			<form method="POST">
				<router-link :to="{name: 'home'}" class="login-form-btn not-found-btn">
					{{ __('fastadminpanel.admin_panel') }}
				</router-link>
				<router-link :to="{name: 'login'}" class="login-form-btn not-found-btn">
					{{ __('fastadminpanel.login') }}
				</router-link>
			</form>
		</div>
		<img src="/vendor/fastadminpanel/images/digiants.svg" alt="" class="digiants">
	</main>
</template>

<script>
const notFoundPage = {
	template: '#not-found',
	props: [],
	data() {
		return {
		}
	},
}
</script>