<script>
const useCrudsStore = Pinia.defineStore('cruds', {
	state: () => ({
		cruds: [],
	}),
	getters: {
	},
	actions: {
		getFields(tableName) {
			const crud = this.cruds.find(c => c.table_name == tableName)

			if (crud) return crud.fields
			return []
		},
		getTitle(tableName) {
			const crud = this.cruds.find(c => c.table_name == tableName)

			if (crud) return crud.title
			return ''
		},
		getDefaultOrder(tableName) {
			const crud = this.cruds.find(c => c.table_name == tableName)

			if (crud) return crud.default_order
			return ''
		},
		addCrud(crud) {
			this.cruds.push(crud)
		},
		removeCrud(tableName) {
			const index = this.cruds.findIndex(c => c.table_name == tableName)

			if (this.cruds[index]) {

				this.cruds.splice(index, 1)
			}
		},
		async fetchData() {

			const response = await req.get('{{ route("admin-api-cruds-index", [], false) }}')
			this.cruds = response.data
		},
	},
})
</script>