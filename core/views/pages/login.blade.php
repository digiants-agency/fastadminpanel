<template id="login">
	<main class="login-form">
		<div class="login-form-fields">
			<div class="login-form-logo-wrapper">
				<a href="/">
					<img src="/vendor/fastadminpanel/images/logo.svg" alt="" class="login-form-logo">
				</a>
				<div class="login-title">{{ __('fastadminpanel.admin_panel') }}</div>
			</div>
			<div class="login-form-title">{{ __('fastadminpanel.sign_in') }}</div>
			<form method="POST">
				<input type="email" v-model="email" class="login-form-input" name="email" placeholder="{{ __('fastadminpanel.email') }}" required autofocus>
				<input type="password" v-model="password" class="login-form-input" name="password" placeholder="{{ __('fastadminpanel.password') }}" required>
				<label class="checkbox">
					<input class="checkbox-input" style="display: none;" type="checkbox" name="remember" v-model="isRemember">
					<div class="checkbox-rectangle">
						<img src="/vendor/fastadminpanel/images/checkbox-mark.svg" alt="" class="checkbox-mark">
					</div>
					<div class="checkbox-text">{{ __('fastadminpanel.remember_me') }}</div>
				</label>
				<button class="login-form-btn" v-on:click.prevent="signIn">
					{{ __('fastadminpanel.login') }}
				</button>
				<div class="login-error" v-if="error" v-text="error"></div>
			</form>
		</div>
		<img src="/vendor/fastadminpanel/images/digiants.svg" alt="" class="digiants">
	</main>
</template>

<script>
const loginPage = {
	template: '#login',
	props: [],
	data() {
		return {
			email: '',
			password: '',
			isRemember: false,
			error: '',
		}
	},
	methods: {
		async signIn() {

			this.error = ''

			const isAuth = await this.userStore.signIn(this.email, this.password, this.isRemember)

			if (!isAuth) {
				this.error = '{{ __('fastadminpanel.login_incorrect') }}'
				return
			}

			this.$router.push({name: 'home'})
		},
	},
	computed: {
		...Pinia.mapStores(useUserStore)
	},
}
</script>