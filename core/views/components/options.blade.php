<script type="text/x-template" id="template-options">
	<div class="options">
		<div class="btn btn-primary" v-on:click="rm_language">{{__('fastadminpanel.delete_lang')}}</div>
		<div class="btn btn-primary" v-on:click="add_language">{{__('fastadminpanel.add_lang')}}</div>
	</div>
</script>

<script>
	Vue.component('template-options', {
		template: '#template-options',
		props: [],
		data() {
			return {

			}
		},
		methods: {
			async rm_language() {

				const lang_tag = prompt('Enter language', '')
				
				if (lang_tag) {

					const response = await req.delete('/admin/api/language/' + lang_tag, {
						blocks: this.blocks,
					})

					document.location.reload()
				}
			},
			async add_language() {

				const lang_tag = prompt('Enter language', '')
				
				if (lang_tag) {

					const response = await req.post('/admin/api/language/' + lang_tag, {
						blocks: this.blocks,
					})

					document.location.reload()
				}
			},
		},
	})
</script>