<script type="text/x-template" id="template-fields">
	<div class="form-group w-100">
		
		<div class="field-title">
			<label class="edit-field-title control-label" v-text="field.title"></label>
			
			<div class="field-remark" v-if="field.remark">
				i
				<div class="field-remark-modal" v-text="field.remark"></div>
			</div>
		</div>


		<div class="edit-field-inner">
			<div v-if="field.type == 'text'">
				<input class="form-control" type="text" v-model="field.value" v-on:change="errors[field.db_title] = ''" maxlength="191">
			</div>
			<div v-else-if="field.type == 'textarea'">
				<textarea class="form-control" v-model="field.value"></textarea>
			</div>
			<div v-else-if="field.type == 'ckeditor'">
				<ckeditor :config="editorConfig" :editor="editor" class="form-control" v-model="field.value"></ckeditor>
			</div>
			<div v-else-if="field.type == 'checkbox'">
				<input class="form-control form-control-checkbox" type="checkbox" v-model="field.value">
			</div>
			<div v-else-if="field.type == 'color'">
				<input class="form-control colorpicker" type="text" :id="field.db_title" v-on:change="errors[field.db_title] = ''">
			</div>
			<div v-else-if="field.type == 'date'">
				<input class="form-control datepicker" data-init="0" type="text" :id="field.db_title" v-on:change="errors[field.db_title] = ''">
			</div>
			<div v-else-if="field.type == 'enum'">
				<select class="form-control" v-model="field.value">
					<option :value="field.enum[index]" v-for="(item, index) in field.enum" v-text="field.enum[index]"></option>
				</select>
			</div>
			<div v-else-if="field.type == 'relationship'">
				<select class="form-control" v-model="fields_instance['id_' + field.relationship_table_name]">
					<option :value="item.id" v-for="item in relationships[field.relationship_table_name]" v-text="item.title"></option>
				</select>
			</div>
			<div v-else-if="field.type == 'photo'" v-on:dragenter="dragenter" v-on:dragleave="dragleave" v-on:dragover="dragover" v-on:drop="drop">
				<input class="form-control" type="text" :id="field.db_title" v-model="field.value" v-on:change="errors[field.db_title] = ''">
				<div class="photo-preview-wrapper">
					<img :src="field.value" alt="" class="photo-preview-img">
					<div class="btn btn-primary" v-on:click="add_photo(field.db_title)">Добавить</div>
				</div>
			</div>
			<div v-else-if="field.type == 'file'">
				<input class="form-control" type="text" :id="field.db_title" v-model="field.value" v-on:change="errors[field.db_title] = ''">
				<div class="btn btn-primary add-file-btn" v-on:click="add_file(field.db_title)">Добавить</div>
			</div>
			<div v-else-if="field.type == 'gallery'">
				<template v-for="(item, index) in field.value">
					<input class="form-control gallery-margin-top" type="text" v-model="field.value[index]">
					<div class="photo-preview-wrapper">
						<img :src="field.value[index]" alt="" class="photo-preview-img">
						<div class="btn btn-danger" v-on:click="remove_gallery(field.db_title, index)">Удалить</div>
					</div>
				</template>
				<div class="btn btn-primary gallery-margin-top" v-on:click="add_gallery(field.db_title)">Добавить</div>
			</div>
			<div v-else-if="field.type == 'number' || field.type == 'money'">
				<input class="form-control" type="text" v-model="field.value" v-on:change="errors[field.db_title] = ''">
			</div>
			<div class="input-error" v-text="errors[field.db_title]"></div>
		</div>
	</div>
</script>

<script>
	Vue.component('template-fields',{
		template: '#template-fields',
		props:['field'],
		components: {
			// Use the <ckeditor> component in this view.
			ckeditor: CKEditor.component
		},
		data: function () {
			return {
				errors: {},
				editor: ClassicEditor,
				editorConfig: {
					extraPlugins: [ MyCustomUploadAdapterPlugin],
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
			dragenter: function(e){
				e.preventDefault()
				e.stopPropagation()
			},
			dragleave: function(e){
				e.preventDefault()
				e.stopPropagation()
			},
			dragover: function(e){
				e.preventDefault()
				e.stopPropagation()
			},
			drop: async function(e){
				e.preventDefault()
				e.stopPropagation()
				
				if (e.buttons == 0 && e.dataTransfer.items.length > 0) {

					const img = e.dataTransfer.items[0]

					if (img.type.match(/image.*/)) {

						const image_file = img.getAsFile()

						const response = await post('/admin/upload-image', {
							upload: image_file,
						}, true)

						const obj = JSON.parse(response.data)

						if (obj.url) {

							this.field.value = '/' + obj.url

						} else {

							alert('Error')
						}

					} else {
						alert('File have to be image')
					}
				}
			},
			add_photo: function(id){

				window.open('/laravel-filemanager?type=image', 'FileManager', 'width=900,height=600');
				window.SetUrl = (items)=>{

					for (var i = 0; i < items.length; i++) {

						var url = items[i].url.replace(/^.*\/\/[^\/]+/, '')

						this.field.value = url
						this.$forceUpdate()

						break;
					}
				};
			},
			add_file: function(id){

                window.open('/laravel-filemanager?type=file', 'FileManager', 'width=900,height=600');
                window.SetUrl = (items)=>{

                    for (var i = 0; i < items.length; i++) {

                        var url = items[i].url.replace(/^.*\/\/[^\/]+/, '')

                        this.field.value = url
                        this.$forceUpdate()

                        break;
                    }
                };
            },
            add_gallery: function(id){
                window.open('/laravel-filemanager?type=image', 'FileManager', 'width=900,height=600');
                window.SetUrl = (items)=>{

                    if (this.field.value)
                        var arr = this.field.value
                    else  var arr = []
                    
                    for (var i = 0; i < items.length; i++) {

                        var url = items[i].url.replace(/^.*\/\/[^\/]+/, '')
                        arr.push(url)
                    }
                    this.field.value = arr
                    this.$forceUpdate()
                };
            },
            remove_gallery: function(id, index){
                this.field.value.splice(index, 1)
                this.$forceUpdate()
            },
		},
		created: function(){
		},
	})
</script>