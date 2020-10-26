<script type="text/x-template" id="template-fields-dynamic">
	<div class="row form-group">
		<label class="col-sm-2 control-label" v-text="field.title"></label>
		<div class="col-sm-10">
			<div v-if="field.type == 'text'">
				<input class="form-control" type="text" v-model="fields_instance[field.db_title]" v-on:change="error = ''" maxlength="191">
			</div>
			<div v-else-if="field.type == 'textarea'">
				<textarea v-on:input="change_textarea" :rows="textarea_height" class="form-control" v-model="fields_instance[field.db_title]"></textarea>
			</div>
			<div v-else-if="field.type == 'ckeditor'">
				<ckeditor :config="editorConfig" :editor="editor" class="form-control" v-model="fields_instance[field.db_title]"></ckeditor>
			</div>
			<div v-else-if="field.type == 'checkbox'">
				<input class="form-control form-control-checkbox" type="checkbox" v-model="fields_instance[field.db_title]">
			</div>
			<div v-else-if="field.type == 'color'">
				<input class="form-control colorpicker" type="text" :id="field.db_title" v-on:change="error = ''">
			</div>
			<div v-else-if="field.type == 'date'">
				<input class="form-control datepicker" data-init="0" type="text" :id="field.db_title" v-on:change="error = ''">
			</div>
			<div v-else-if="field.type == 'enum'">
				<select class="form-control" v-model="fields_instance[field.db_title]">
					<option :value="field.enum[index]" v-for="(item, index) in field.enum" v-text="field.enum[index]"></option>
				</select>
			</div>
			<div v-else-if="field.type == 'relationship'">
				<select v-if="field.relationship_count == 'single' && field.title == 'Артист'" class="form-control" v-model="fields_instance['id_' + field.relationship_table_name]">
					<option :value="item.id" v-for="item in relationships['artist']" v-text="item.title"></option>
				</select>
				<select v-else-if="field.relationship_count == 'single'" class="form-control" v-model="fields_instance['id_' + field.relationship_table_name]">
					<option :value="item.id" v-for="item in relationships[field.relationship_table_name]" v-text="item.title"></option>
				</select>
				<div v-else-if="field.relationship_count == 'many'">
					<div class="relationship-many" v-for="(elm, index) in fields_instance['$' + table_name + '_' + field.relationship_table_name]">
						<select class="form-control" v-model="elm[field.relationship_table_name]">
							<option :value="item.id" v-for="item in relationships[field.relationship_table_name]" v-text="item.title"></option>
						</select>
						<div class="btn btn-danger" v-on:click="remove_relationship_field(field, index)">Delete</div>
					</div>
					<div class="btn btn-primary" v-on:click="add_relationship_field(field)">Add</div>
				</div>
			</div>
			<div v-else-if="field.type == 'photo'">
				<input class="form-control" type="text" :id="field.db_title" v-model="fields_instance[field.db_title]" v-on:change="error = ''">
				<div class="photo-preview-wrapper">
					<img :src="fields_instance[field.db_title]" alt="" class="photo-preview-img">
					<div class="btn btn-primary" v-on:click="add_photo(field.db_title)">Add photo</div>
				</div>
			</div>
			<div v-else-if="field.type == 'file'">
				<input class="form-control" type="text" :id="field.db_title" v-model="fields_instance[field.db_title]" v-on:change="error = ''">
				<div class="btn btn-primary add-file-btn" v-on:click="add_file(field.db_title)">Add file</div>
			</div>
			<div v-else-if="field.type == 'gallery'">
				<template v-for="(item, index) in fields_instance[field.db_title]">
					<input class="form-control gallery-margin-top" type="text" v-model="fields_instance[field.db_title][index]">
					<div class="photo-preview-wrapper">
						<img :src="fields_instance[field.db_title][index]" alt="" class="photo-preview-img">
						<div class="btn btn-danger" v-on:click="remove_gallery(field.db_title, index)">Delete photo</div>
					</div>
				</template>
				<div class="btn btn-primary gallery-margin-top" v-on:click="add_gallery(field.db_title)">Add photos</div>
			</div>
			<div v-else-if="field.type == 'translater'">
				<div v-for="(value, key, j) in fields_instance[field.db_title]">
					<h2 v-text="key + ':'" style="margin-bottom: 15px;"></h2>
					<template v-for="(v, k, i) in fields_instance[field.db_title][key]">
						<div v-text="k + ':'"></div>
						<textarea class="form-control translate-field" v-model="fields_instance[field.db_title][key][k]"></textarea>
					</template>
				</div>
			</div>
			<div v-else-if="field.type == 'number' || field.type == 'money'">
				<input class="form-control" type="text" v-model="fields_instance[field.db_title]" v-on:change="error = ''">
			</div>
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-fields-dynamic',{
		template: '#template-fields-dynamic',
		props:['field', 'fields_instance', 'relationships', 'index', 'table_name'],
		components: {
			// Use the <ckeditor> component in this view.
			ckeditor: CKEditor.component
		},
		data: function () {
			return {
				error: '',
				editor: ClassicEditor,
				editorConfig: {
					extraPlugins: [ MyCustomUploadAdapterPlugin ],
				},
				textarea_height: 1,
			}
		},
		methods: {
			check: function(){

				let instance = this.fields_instance
				let field = this.field

				if (instance[field.db_title] == undefined) {
					if (field.type == 'relationship' && field.relationship_count == 'single' && instance['id_' + field.relationship_table_name] == undefined)
						instance['id_' + field.relationship_table_name] = 0
					else if (field.type != 'relationship') {
						instance[field.db_title] = this.get_standart_val(field.type)
					}
				}
				
				if (field.required != 'optional' && !instance[field.db_title]) {
					this.error = 'This field is required'
				} else if (field.required == 'required_once') {
					// TODO
				}
				
					
				if (field.type == 'text') {
					if (instance[field.db_title].length > 191)
						this.error = 'More than maxlength (191 symbols)'
				} else if (field.type == 'number' || field.type == 'money') {
					if (!$.isNumeric(instance[field.db_title]))
						this.error = 'Field must be numeric. Use "." instead of ","'
				}

				if (this.error == '')
					return true
				return false
			},
			get_standart_val: function(type){
				// TODO: enum, relationship
				if (type == 'checkbox' || type == 'money' || type == 'number') return 0
				if (type == 'color') return '#000000'
				if (type == 'date') return '2000-00-00'
				if (type == 'datetime') return '2000-00-00 12:00:00'
				if (type == 'gallery') return []
				if (type == 'translater') return {}
				if (type == 'repeat') return ''
				return ''
			},
			change_textarea: function(){

				let count = (this.fields_instance[this.field.db_title].match(/\n/g) || []).length
				
				this.textarea_height = count + 1
			},
			add_photo: function(id){

				window.open('/laravel-filemanager?type=image', 'FileManager', 'width=900,height=600');
				window.SetUrl = (items)=>{

					for (var i = 0; i < items.length; i++) {

						var url = items[i].url.replace(document.location.origin, '')

						this.$parent.fields_instance[id] = url
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

						this.$parent.fields_instance[id] = url
						this.$forceUpdate()

						break;
					}
				};
			},
			add_gallery: function(id){
				window.open('/laravel-filemanager?type=image', 'FileManager', 'width=900,height=600');
				window.SetUrl = (items)=>{

					if (this.$parent.fields_instance[id])
						var arr = this.$parent.fields_instance[id]
					else  var arr = []
					
					for (var i = 0; i < items.length; i++) {

						var url = items[i].url.replace(document.location.origin, '')
						arr.push(url)
					}
					this.$parent.fields_instance[id] = arr
					this.$forceUpdate()
				};
			},
			remove_gallery: function(id, index){
				this.$parent.fields_instance[id].splice(index, 1)
				this.$forceUpdate()
			},
			add_relationship_field: function(field){

				var relationships = this.relationships[field.relationship_table_name]

				var add = {}

				if (relationships.length > 0)
					add[field.relationship_table_name] = relationships[0].id
				else add[field.relationship_table_name] = 0

				this.$parent.fields_instance['$' + this.table_name + '_' + field.relationship_table_name].push(add)
				this.$forceUpdate()
			},
			remove_relationship_field: function(field, id){
				
				this.$parent.fields_instance['$' + this.table_name + '_' + field.relationship_table_name].splice(id, 1)
				this.$forceUpdate()
			},
		},
		created: function(){
		},
	})
</script>