<template id="field-ckeditor">
	<div class="form-group">
		<div class="field-title">
			<label class="edit-field-title control-label" v-text="field.title"></label>
			<div class="field-remark" v-if="field.remark">
				i
				<div class="field-remark-modal" v-text="field.remark"></div>
			</div>
		</div>
		<div class="edit-field-inner">
			<ckeditor class="form-control" v-model="value"></ckeditor>
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</template>

<script>
app.component('field-ckeditor', {
	template: '#field-ckeditor',
	mixins: [recursiveFieldMixin],
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

			if (!this.value) {

				if (this.field.required != 'optional') {

					this.error = "{{ __('fastadminpanel.required_field') }}"

				} else if (this.field.required == 'required_once') {
					
					// TODO

				} else {

					this.value = ''
				}
			}

			if (this.error == '')
				return true
			return false
		},
	},
})
</script>