<script>
const useLoaderStore = Pinia.defineStore('loader', {
	state: () => ({
		count: 0,
	}),
	getters: {
		isLoading: (state) => !!state.count,
	},
	actions: {
		increment() {
			this.count++
		},
		decrement() {
			this.count--
		},
	},
})
</script>