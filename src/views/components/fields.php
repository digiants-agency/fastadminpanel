<script type="text/x-template" id="template-fields">
	<div class="row form-group">
		<label class="col-sm-2 control-label" v-text="field.title"></label>
		<div class="col-sm-10">
			<div v-if="field.type == 'text'">
				<input class="form-control" type="text" v-model="field.value" v-on:change="errors[field.db_title] = ''">
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
			<div v-else-if="field.type == 'photo'">
				<input class="form-control" type="text" :id="field.db_title" v-model="field.value" v-on:change="errors[field.db_title] = ''">
				<div class="photo-preview-wrapper">
					<img :src="field.value" alt="" class="photo-preview-img">
					<div class="btn btn-primary" v-on:click="add_photo(field.db_title)">Add photo</div>
				</div>
			</div>
			<div v-else-if="field.type == 'file'">
				<input class="form-control" type="text" :id="field.db_title" v-model="field.value" v-on:change="errors[field.db_title] = ''">
				<div class="btn btn-primary add-file-btn" v-on:click="add_file(field.db_title)">Add file</div>
			</div>
			<div v-else-if="field.type == 'gallery'">
				<template v-for="(item, index) in field.value">
					<input class="form-control gallery-margin-top" type="text" v-model="field.value[index]">
					<div class="photo-preview-wrapper">
						<img :src="field.value[index]" alt="" class="photo-preview-img">
						<div class="btn btn-danger" v-on:click="remove_gallery(field.db_title, index)">Delete photo</div>
					</div>
				</template>
				<div class="btn btn-primary gallery-margin-top" v-on:click="add_gallery(field.db_title)">Add photos</div>
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
					extraPlugins: [ MyCustomUploadAdapterPlugin ],
				},
			}
		},
		methods: {
			add_photo: function(id){

				window.open('/laravel-filemanager?type=image', 'FileManager', 'width=900,height=600');
				window.SetUrl = (items)=>{

					for (var i = 0; i < items.length; i++) {

						var url = items[i].url.replace(document.location.origin, '')

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

                        var url = items[i].url.replace(document.location.origin, '')

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

                        var url = items[i].url.replace(document.location.origin, '')
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