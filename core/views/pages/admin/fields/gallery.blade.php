<template id="field-gallery">
	<div class="form-group">
		<div class="field-title">
			<label class="edit-field-title control-label" v-text="field.title"></label>
			<div class="field-remark" v-if="field.remark">
				i
				<div class="field-remark-modal" v-text="field.remark"></div>
			</div>
		</div>
		<div class="edit-field-inner">
			<template v-for="(item, index) in value">
				<input class="form-control gallery-margin-top" type="text" v-model="value[index]">
				<div class="photo-preview-wrapper">
					<img :src="value[index]" alt="" class="photo-preview-img">
					<div class="btn-delete-photo" v-on:click="removeImage(index)">
						<img src="/vendor/fastadminpanel/images/close-grey.svg" alt="">
					</div>
				</div>
			</template>
			<div class="btn btn-primary gallery-margin-top" v-on:click="changeGallery()">{{ __('fastadminpanel.add_field') }}</div>
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</template>

<script>
app.component('field-gallery', {
	template: '#field-gallery',
	mixins: [recursiveFieldMixin, addFileMixin],
	props: ['field', 'pointer'],
	data() {
		return {
			error: '',
		}
	},
	computed: {
		default() {
			return []
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
			if (!this.value) this.value = []
			return true
		},
		changeGallery() {

			this.addFile((gallery) => {

				let startValues = []
				if (this.value) startValues = this.value

				this.value = startValues.concat(gallery)
			}, 'image', true)
		},
		removeImage(index) {
			this.value.splice(index, 1)
			// this.$forceUpdate()
		},
	},
})
</script>