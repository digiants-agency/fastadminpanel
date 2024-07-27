<template id="field-file">
	<div class="form-group">
		<div class="field-title">
			<label class="edit-field-title control-label" v-text="field.title"></label>
			<div class="field-remark" v-if="field.remark">
				i
				<div class="field-remark-modal" v-text="field.remark"></div>
			</div>
		</div>
		<div class="edit-field-inner">
			<input class="form-control" type="text" v-model="value" v-on:change="error = ''">
			<div class="btn btn-primary add-file-btn" v-on:click="changeFile()">{{ __('fastadminpanel.add_field') }}</div>
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</template>

<script>
app.component('field-file', {
	template: '#field-file',
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
		check() {

			if (this.field.required != 'optional' && !this.file.value) {
				this.error = "{{ __('fastadminpanel.required_field') }}"
			} else if (this.field.required == 'required_once') {
				// TODO
			}

			if (!this.value) this.value = ''

			return true
		},
		changeFile() {

			this.addFile((file) => this.value = file, 'file')
		},
	},
})
</script>