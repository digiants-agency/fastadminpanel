<template id="import">
	<div class="import">
		<router-link :to="{name: 'crudsEntities', params: {table: table}}" class="btn btn-primary align-self-flex-start btn-edit">
			<img src="/vendor/fastadminpanel/images/arrow-back.svg" alt="" />
			{{ __('fastadminpanel.back') }}
		</router-link>
		<div class="space-between">		
			<h1 v-text="'{{ __('fastadminpanel.import') }} ' + title"></h1>
		</div>
		<div class="index-body" style="padding-bottom: 2vw; margin-bottom: 2vw;">
			<div class="form-group">
				<label class="menu-item-title">{{ __('fastadminpanel.file') }}</label>
				<div class="menu-item-input">
					<div class="import_input_row">
						<input type="file" v-on:change="setXlsx" name="xlsx" class="import_input">
					</div>
				</div>
			</div>
			<div class="edit-fields-btns">
				<button class="btn btn-primary" v-on:click="send">
					{{ __('fastadminpanel.import') }}
				</button>
			</div>
		</div>
	</div>
</template>

<script>
const crudsImportPage = {
	template: '#import',
	data() {
		return {
			xlsx: '',
		}
	},
	computed: {
		...Pinia.mapStores(useCrudsStore),
		table() {
			return this.$route.params.table
		},
		// fields() {
		// 	return this.crudsStore.getFields(this.table)
		// },
		title() {
			return this.crudsStore.getTitle(this.table)
		},
	},
	methods: {
		setXlsx(event) {
			this.xlsx = event.target.files[0];
		},
		async send() {

			const route = "{{ route('admin-api-import', ['table' => 'table'], false) }}"
				.replace('table', this.table)

			const response = await req.post(route, {
				xlsx: this.xlsx,
			}, true)

			if (response.success) {
				
				alert("Success!")
				// location.href = '/admin/cruds/' + this.table

			} else {
				
				if (response.data.error) alert(response.data.error)
				else alert('Error')
			}
		},
	},
}
</script>