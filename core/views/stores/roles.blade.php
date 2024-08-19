<script>
const useRolesStore = Pinia.defineStore('roles', {
	state: () => ({
		id_roles: 0,
		roles: [],
		permissions: [],
	}),
	getters: {
	},
	actions: {
		async fetchData() {
			
			await this.fetchRoles()
			await this.fetchPermissions()
		},
		async fetchRoles() {

			const response = await req.get('{{ route("admin-api-roles-index", [], false) }}')
			this.roles = response.data.roles
			this.id_roles = response.data.id_roles
		},
		async fetchPermissions() {

			const response = await req.get('{{ route("admin-api-roles-permissions-index", [], false) }}')
			this.permissions = response.data
		},
		async updatePermissions() {

			const response = await req.put('{{ route("admin-api-roles-permissions-update", [], false) }}', {
				permissions: this.permissions
			})
		},
		removePermission(id) {

			const index = this.permissions.findIndex(d => d.id == id)

			this.permissions.splice(index, 1)
		},
		async addPermission() {

			const maxId = Math.max(...this.permissions.map(p => p.id))
			
			this.permissions.push({
				id: maxId + 1,
				slug: '',
				id_roles: 0,
				admin_read: 0,
				admin_edit: 0,
				api_create: 0,
				api_read: 0,
				api_update: 0,
				api_delete: 0,
				all: 0,
			})
		},
		can(slug, name) {

			const permission = this.permissions.filter(p => p.id_roles == this.id_roles || p.id_roles == 0)
			.filter(p => p.slug == slug || p.slug == 'all')
			.find(p => p[name] == 1 || p.all == 1)

			return !!permission
		},
	},
})
</script>