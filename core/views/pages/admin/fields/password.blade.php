<template id="field-password">
	<div class="form-group">
		<div class="field-title">
			<label class="edit-field-title control-label" v-text="field.title"></label>
			<div class="field-remark" v-if="field.remark">
				i
				<div class="field-remark-modal" v-text="field.remark"></div>
			</div>
		</div>
		<div class="edit-field-inner">
			<input class="form-control" type="password" v-model="value" v-on:change="error = ''" maxlength="191">
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</template>

<script>
app.component('field-password', {
	template: '#field-password',
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
			if (!this.value) this.value = ''
			return true
		},
	},
})
</script>