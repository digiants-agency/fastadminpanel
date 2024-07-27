<script>
const useUserStore = Pinia.defineStore('user', {
	state: () => ({
		user: JSON.parse('@json(Auth::user())'),
	}),
	getters: {
	},
	actions: {
		async isAuth() {

			return !!this.user
		},
		async signIn(email, password, isRemember) {

			const response = await req.post('{{route("admin-api-sign-in", [], false)}}', {
				email: email,
				password: password,
				is_remember: isRemember,
			})
			
			if (response.success) {
				
				this.user = response.data
				return true
			}

			return false
		},
		async signOut() {

			await req.get('{{route("admin-api-sign-out", [], false)}}')

			// this.user = null

			location.reload()
		},
	},
})
</script>