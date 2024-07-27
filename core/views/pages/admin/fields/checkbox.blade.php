<template id="field-checkbox">
	<div class="form-group">
		<div class="field-title">
			<label class="edit-field-title control-label" v-text="field.title"></label>
			<div class="field-remark" v-if="field.remark">
				i
				<div class="field-remark-modal" v-text="field.remark"></div>
			</div>
		</div>
		<div class="edit-field-inner">
			<label class="checkbox">
				<div class="checkbox-rectangle" :class="{active: value}" v-on:click="value = !value">
					<img src="/vendor/fastadminpanel/images/checkbox-mark.svg" alt="" class="checkbox-mark">
				</div>
			</label>
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</template>

<script>
app.component('field-checkbox', {
	template: '#field-checkbox',
	mixins: [recursiveFieldMixin],
	props: ['field', 'pointer'],
	data() {
		return {
			error: '',
		}
	},
	computed: {
		default() {
			return false
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
			return true
		},
	},
})
</script>