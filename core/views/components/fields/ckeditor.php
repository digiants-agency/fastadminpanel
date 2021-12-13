<script type="text/x-template" id="template-field-ckeditor">
	<div class="row form-group">
		<label class="col-sm-2 control-label" v-text="field.title"></label>
		<div class="col-sm-10">
			<ckeditor :config="editorConfig" :editor="editor" class="form-control" v-model="field.value"></ckeditor>
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-ckeditor',{
		template: '#template-field-ckeditor',
		props:['field'],
		components: {
			ckeditor: CKEditor.component
		},
		data: function () {
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
			check: function(){

				if (!this.field.value) {

					if (this.field.required != 'optional') {

						this.error = 'This field is required'

					} else if (this.field.required == 'required_once') {
						
						// TODO

					} else {

						this.field.value = ''
					}
				}

				if (this.error == '')
					return true
				return false
			},
		},
	})
</script>