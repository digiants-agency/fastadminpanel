<script>
const addFileMixin = {
	methods: {
		addFile(setFile, type = 'image', isMultiple = false) {

			window.open('/laravel-filemanager?type=' + type, 'FileManager', 'width=900,height=600');
			window.SetUrl = (items) => {

				const filteredItems = items.map(i => decodeURIComponent(i.url.replace(/^.*\/\/[^\/]+/, '')))
				setFile(isMultiple ? filteredItems : filteredItems[0])
			}
		},
	},
}
</script>