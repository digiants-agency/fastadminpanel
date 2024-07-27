<template id="field-number">
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
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</template>

<script>
app.component('field-number', {
	template: '#field-number',
	mixins: [recursiveFieldMixin],
	props: ['field', 'pointer'],
	data() {
		return {
			error: '',
		}
	},
	computed: {
		default() {
			return 0
		},
	},
	watch: {
	},
	created() {
	},
	mounted() {
	},
	methods: {
		check() {
			if (!/^-?\d+$/.test(this.value))	// is numeric
				this.error = "{{ __('fastadminpanel.numeric_field') }}"

			if (this.error == '') return true

			return false
		},
	},
})
</script>