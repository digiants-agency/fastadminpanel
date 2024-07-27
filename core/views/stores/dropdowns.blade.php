<script>
const useDropdownsStore = Pinia.defineStore('dropdowns', {
	state: () => ({
		dropdowns: [],
	}),
	getters: {
	},
	actions: {
		add() {
			this.dropdowns.push({
				slug: '',
				title: '',
				sort: 0,
				icon: '',
			})
		},
		remove(slug) {

			const index = this.dropdowns.findIndex(d => d.slug == slug)

			this.dropdowns.splice(index, 1)
		},
		async update() {

			const response = await req.put('{{ route("admin-api-dropdowns-update", [], false) }}', {
				dropdowns: this.dropdowns
			})
		},
		async fetchData() {

			const response = await req.get('{{ route("admin-api-dropdowns-index", [], false) }}')
			this.dropdowns = response.data
		},
	},
})
</script>