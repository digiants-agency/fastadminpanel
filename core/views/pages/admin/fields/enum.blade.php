<template id="field-enum">
	<div class="form-group">
		<div class="field-title">
			<label class="edit-field-title control-label" v-text="field.title"></label>
			<div class="field-remark" v-if="field.remark">
				i
				<div class="field-remark-modal" v-text="field.remark"></div>
			</div>
		</div>
		<div class="edit-field-inner">
			<select class="form-control" v-model="value">
				<option v-for="(item, index) in field.enum" :value="field.enum[index]" v-text="field.enum[index]"></option>
			</select>
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</template>

<script>
app.component('field-enum', {
	template: '#field-enum',
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
		if (!this.value && this.field.enum.length > 0) {
			this.value = this.field.enum[0]
		}
	},
	methods: {
		check() {
			return true
		},
	},
})
</script>