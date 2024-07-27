<script>
const useMenuStore = Pinia.defineStore('menu', {
	state: () => ({
		isDev: {{config('app.debug') || isset($_GET[$hiddenMenuParam]) ? 'true' : 'false'}},
		activeDropdowns: {},
	}),
	getters: {
		menu: (state) => {

			const dropdownsStore = useDropdownsStore()
			const crudsStore = useCrudsStore()
			const singlesStore = useSinglesStore()
			
			const menu = []
			const dropdowns = dropdownsStore.dropdowns.sort((a, b) => a.sort - b.sort)
			const buttons = singlesStore.singles
			.concat(crudsStore.cruds)
			.map(b => ({
				id: b.table_name ?? b.id,
				title: b.title,
				sort: b.sort,
				icon: b.icon,
				type: b.table_name ? 'crud' : 'single',
				count: 0,
				link: b.table_name ? 
					{name: 'crudsEntities', params: {table: b.table_name}} : 
					{name: 'singlesEntity', params: {id: b.id}},
				isActive: state.isDev || !b.is_dev,
				parentId: b.dropdown_slug,
			}))
			.sort((a, b) => a.sort - b.sort)
			
			for (const dropdown of dropdowns) {

				menu.push({
					id: dropdown.slug,
					title: dropdown.title,
					sort: dropdown.sort,
					icon: dropdown.icon,
					type: 'dropdown',
					count: 0,
					link: false,
					isActive: state.activeDropdowns[dropdown.slug] ?? false,
					parentId: 0,
					children: buttons.filter(e => e.parentId == dropdown.slug),
				})
			}

			const elementsLeft = buttons.filter(e => e.parentId == 0)
			
			return menu.concat(elementsLeft)
		},
	},
	actions: {
		toggleDropdown(dropdownId) {

			if (this.activeDropdowns[dropdownId]) {
				delete this.activeDropdowns[dropdownId]
			} else {
				this.activeDropdowns[dropdownId] = true
			}
		},
	},
})
</script>