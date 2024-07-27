<template id="field-textarea">
	<div class="form-group">
		<div class="field-title">
			<label class="edit-field-title control-label" v-text="field.title"></label>
			<div class="field-remark" v-if="field.remark">
				i
				<div class="field-remark-modal" v-text="field.remark"></div>
			</div>
		</div>
		<div class="edit-field-inner">
			<textarea v-on:input="change" :rows="textareaHeight" class="form-control" v-model="value" maxlength="65000"></textarea>
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</template>

<script>
app.component('field-textarea', {
	template: '#field-textarea',
	mixins: [recursiveFieldMixin],
	props: ['field', 'pointer'],
	data() {
		return {
			error: '',
			textareaHeight: 1,
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

			if (this.field.required != 'optional' && !this.value) {
				this.error = 'This field is required'
			} else if (this.field.required == 'required_once') {
				// TODO
			}
								
			if (this.value.length > 65000)
				this.error = 'More than maxlength (65000 symbols)'

			if (this.error == '')
				return true
			return false
		},
		change(e) {

			let count = (this.value.match(/\n/g) || []).length
			
			this.textareaHeight = count + 1

			// if (this.field.db_title == 'title') {
			// 	this.$root.$emit('title_changed', e.target.value)
			// }
		},
	},
})
</script>