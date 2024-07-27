<template id="ckeditor">
	<div class="ckeditor"></div>
</template>
{{-- copied from compressed file --}}
<script>
app.component('ckeditor', {
	template: '#ckeditor',
	props: ['modelValue'],
	emits: ['update:modelValue'],
	data() {
		return {
			lastUpdate: 0,
			lastEditorData: '',
			config: {
				extraPlugins: [ MyCustomUploadAdapterPlugin ],
				toolbar: {
					items: [
						'heading', '|', 'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', '|', 'fontSize', 'fontColor', 'fontBackgroundColor', '|', 'bulletedList', 'numberedList', 'code', 'blockQuote', '|', 'indent', 'outdent', 'alignment', '|', 'link', 'imageUpload', 'imageTextAlternative', 'insertTable', 'mediaEmbed', 'htmlEmbed', 'undo', 'redo',
					],
					shouldNotGroupWhenFull: true,
				},
				table: {
					contentToolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties' ]
				},
			},
		}
	},
	computed: {
	},
	watch: {
		modelValue(t, e) {
			t !== e && t !== this.lastEditorData && this.instance.setData(t);
		},
	},
	created() {
	},
	mounted() {
		ClassicEditor
		.create(this.$el, this.config)
		.then((t) => {
			this.instance = t
			// t.isReadOnly = this.disabled;
			t.model.document.on(
				"change:data",
				() => {
					clearTimeout(this.lastUpdate)

					this.lastUpdate = setTimeout((e) => {
						const n = (this.lastEditorData = t.getData());
						this.$emit("update:modelValue", n);
					}, 300)
				}
			)
			t.setData(this.modelValue)
		})
		.catch((t) => {
			console.error(t);
		});
	},
	unmounted() {
		this.instance && (this.instance.destroy(), (this.instance = null))
	},
	methods: {
	},
})
</script>