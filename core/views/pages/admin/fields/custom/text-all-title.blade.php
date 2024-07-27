<template id="field-text-all-title">
	<div class="form-group">
		<div class="field-title">
			<label class="edit-field-title control-label" v-text="field.title"></label>
			<div class="field-remark" v-if="field.remark">
				i
				<div class="field-remark-modal" v-text="field.remark"></div>
			</div>
		</div>
		<div class="edit-field-inner">
			<input class="form-control" type="text" v-model="value" v-on:change="error = ''" v-on:input="change" maxlength="191">
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</template>

<script>
app.component('field-text-all-title', {
	template: '#field-text-all-title',
	mixins: [recursiveFieldMixin],
	props: ['field', 'pointer', 'table', 'parent_id'],
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

			const val = this.value

			if (this.field.required != 'optional' && !val) {
				this.error = 'This field is required'
			} else if (this.field.required == 'required_once') {
				// TODO
			}

			if (val.length > 191)
				this.error = 'More than maxlength (191 symbols)'

			if (this.error == '')
				return true
			return false
		},
		change(e) {
			
			Observer.dispatch('field_title_changed', e.target.value, this.table, this.parent_id)
		},
	},
})
</script>