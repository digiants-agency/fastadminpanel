<script>
const useLanguageStore = Pinia.defineStore('language', {
	state: () => ({
		languages: JSON.parse('@json(Lang::all())'),
		tag: '{{Lang::get()}}',
	}),
	getters: {
		all: (state) => state.languages,
		count: (state) => state.languages.length,
		main: (state) => state.languages.find(l => l.main_lang == 1),
		isMain: (state) => state.main.tag == state.tag,
	},
	actions: {
		async remove(id) {

			if (!confirm("Are you sure?")) {
				return
			}

			const route = '{{ route("admin-api-languages-destroy", ["language" => 0], false) }}'.replace('0', id)

			const response = await req.delete(route)

			if (response.success) document.location.reload()
			else alert("Error! " + response.data.message)
		},
		async add(tag) {

			if (!confirm("Are you sure?")) {
				return
			}

			const response = await req.post('{{ route("admin-api-languages-store", [], false) }}', {
				tag: tag,
			})

			if (response.success) document.location.reload()
			else alert("Error! " + response.data.message)
		},
		async saveMain(id) {

			if (!confirm("Are you sure?")) {
				return
			}

			const route = '{{ route("admin-api-languages-update", ["language" => 0], false) }}'.replace('0', id)

			const response = await req.put(route)

			if (response.success) document.location.reload()
			else alert("Error! " + response.data.message)
		},
		async set(tag) {

			if (tag == this.tag) return

			let path = location.pathname

			if (!this.isMain) {
				
				path = path.substring(3)
			}

			if (tag == this.main.tag) {

				location = path
				return
			}

			location = `/${tag}${path}`
		},
	},
})
</script>