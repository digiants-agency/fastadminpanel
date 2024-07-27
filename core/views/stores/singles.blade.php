<script>
const useSinglesStore = Pinia.defineStore('singles', {
	state: () => ({
		singles: [],
	}),
	getters: {
	},
	actions: {
		async fetchData(isFull = false) {

			const response = await req.get('{{ route("admin-api-singles-values-index", [], false) }}', {
				is_full: isFull ? 1 : 0,
			})
			this.singles = response.data
		},
		canEdit(id) {
			
			const single = this.singles.find(s => s.id == id)

			const rolesStore = useRolesStore()

			return rolesStore.can(single.slug, 'admin_edit')
		},
	},
})
</script>