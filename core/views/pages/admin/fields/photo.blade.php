<template id="field-photo">
	<div class="form-group" v-on:dragenter="dragenter" v-on:dragleave="dragleave" v-on:dragover="dragover" v-on:drop="drop">
		<div class="field-title">
			<label class="edit-field-title control-label" v-text="field.title"></label>
			<div class="field-remark" v-if="field.remark">
				i
				<div class="field-remark-modal" v-text="field.remark"></div>
			</div>
		</div>
		<div class="edit-field-inner">
			<input class="form-control" type="text" v-model="value" v-on:change="error = ''">
			<div class="photo-preview-wrapper">
				<img :src="value" alt="" class="photo-preview-img">
				<div class="btn btn-primary" v-on:click="changePhoto()">{{ __('fastadminpanel.add_field') }}</div>
			</div>
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</template>

<script>
app.component('field-photo', {
	template: '#field-photo',
	mixins: [recursiveFieldMixin, addFileMixin],
	props: ['field', 'pointer'],
	data() {
		return {
			error: '',
		}
	},
	computed: {
	},
	watch: {
	},
	created() {
	},
	mounted() {
	},
	methods: {
		dragenter(e) {
			e.preventDefault()
			e.stopPropagation()
		},
		dragleave(e) {
			e.preventDefault()
			e.stopPropagation()
		},
		dragover(e) {
			e.preventDefault()
			e.stopPropagation()
		},
		async drop(e) {
			e.preventDefault()
			e.stopPropagation()
			
			if (e.buttons == 0 && e.dataTransfer.items.length > 0) {

				const img = e.dataTransfer.items[0]

				if (img.type.match(/image.*/)) {

					const response = await req.post("{{ route('admin-api-image-store', [], false) }}", {
						upload: img.getAsFile(),
					}, true)

					if (response.success) this.value = response.data.url
					else alert('Error')

				} else {

					alert('The file has to be image')
				}
			}
		},
		check() {

			if (this.field.required != 'optional' && !this.file.value) {
				this.error = 'This field is required'
			} else if (this.field.required == 'required_once') {
				// TODO
			}

			if (!this.value)
				this.value = ''

			return true
		},
		changePhoto() {

			this.addFile((image) => this.value = image)
		},
	},
})
</script>