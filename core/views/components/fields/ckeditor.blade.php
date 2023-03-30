<script type="text/x-template" id="template-field-ckeditor">
	<div class="form-group">
		
		<div class="field-title">
			<label class="edit-field-title control-label" v-text="field.title"></label>
			
			<div class="field-remark" v-if="field.remark">
				i
				<div class="field-remark-modal" v-text="field.remark"></div>
			</div>
		</div>

		<div class="edit-field-inner">
			<ckeditor :config="editorConfig" :editor="editor" class="form-control" v-model="value"></ckeditor>
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-ckeditor', {
		template: '#template-field-ckeditor',
		props: ['field', 'pointer'],
		mixins: [recursiveFieldMixin],
		components: {
			ckeditor: CKEditor.component
		},
		data() {
			return {
				error: '',
				editor: ClassicEditor,
				editorConfig: {
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
		methods: {
			check() {

				if (!this.value) {

					if (this.field.required != 'optional') {

						this.error = '{{ __('fastadminpanel.required_field') }}'

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
		created() {
		},
	})
</script>