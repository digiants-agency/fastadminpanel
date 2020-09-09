<script type="text/x-template" id="template-edit">
	<div class="edit">
		<div class="col-sm-10 offset-sm-2">
			<div class="space-between">
				<h1 v-if="id == 0">Add new</h1>
				<h1 v-else>Edit</h1>
				<router-link :to="'/admin/' + menu_item.table_name" class="btn btn-primary align-self-flex-start">
					Back
				</router-link>
			</div>
		</div>
		<div v-for="(field, index) in menu_item.fields" class="row form-group" v-if="field.is_visible">
			<label class="col-sm-2 control-label" v-text="field.title"></label>
			<div class="col-sm-10">
				<div v-if="field.type == 'text'">
					<input class="form-control" type="text" v-model="fields_instance[field.db_title]" v-on:change="errors[field.db_title] = ''">
				</div>
				<div v-else-if="field.type == 'textarea'">
					<textarea class="form-control" v-model="fields_instance[field.db_title]"></textarea>
				</div>
				<div v-else-if="field.type == 'ckeditor'">
					<ckeditor :config="editorConfig" :editor="editor" class="form-control" v-model="fields_instance[field.db_title]"></ckeditor>
				</div>
				<div v-else-if="field.type == 'checkbox'">
					<input class="form-control form-control-checkbox" type="checkbox" v-model="fields_instance[field.db_title]">
				</div>
				<div v-else-if="field.type == 'color'">
					<input class="form-control colorpicker" type="text" :id="field.db_title" v-on:change="errors[field.db_title] = ''">
				</div>
				<div v-else-if="field.type == 'date'">
					<input class="form-control datepicker" data-init="0" type="text" :id="field.db_title" v-on:change="errors[field.db_title] = ''">
				</div>
				<div v-else-if="field.type == 'enum'">
					<select class="form-control" v-model="fields_instance[field.db_title]">
						<option :value="field.enum[index]" v-for="(item, index) in field.enum" v-text="field.enum[index]"></option>
					</select>
				</div>
				<div v-else-if="field.type == 'relationship'">
					<select v-if="field.relationship_count == 'single'" class="form-control" v-model="fields_instance['id_' + field.relationship_table_name]">
						<option :value="item.id" v-for="item in relationships[field.relationship_table_name]" v-text="item.title"></option>
					</select>
					<div v-else>
						<div class="relationship-many" v-for="(elm, index) in fields_instance['$' + menu_item.table_name + '_' + field.relationship_table_name]">
							<select class="form-control" v-model="elm[field.relationship_table_name]">
								<option :value="item.id" v-for="item in relationships[field.relationship_table_name]" v-text="item.title"></option>
							</select>
							<div class="btn btn-danger" v-on:click="remove_relationship_field(field, index)">Delete</div>
						</div>
						<div class="btn btn-primary" v-on:click="add_relationship_field(field)">Add</div>
					</div>
				</div>
				<div v-else-if="field.type == 'photo'">
					<input class="form-control" type="text" :id="field.db_title" v-model="fields_instance[field.db_title]" v-on:change="errors[field.db_title] = ''">
					<div class="photo-preview-wrapper">
						<img :src="fields_instance[field.db_title]" alt="" class="photo-preview-img">
						<div class="btn btn-primary" v-on:click="add_photo(field.db_title)">Add photo</div>
					</div>
				</div>
				<div v-else-if="field.type == 'file'">
					<input class="form-control" type="text" :id="field.db_title" v-model="fields_instance[field.db_title]" v-on:change="errors[field.db_title] = ''">
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
					<input class="form-control" type="text" v-model="fields_instance[field.db_title]" v-on:change="errors[field.db_title] = ''">
				</div>
				<div class="input-error" v-text="errors[field.db_title]"></div>
			</div>
		</div>
		<div class="row form-group">
			<label class="col-sm-2 control-label"></label>
			<div class="col-sm-10">
				<button v-if="id == 0" class="btn btn-primary" v-on:click="create_fields_instance()">Create</button>
				<button v-else class="btn btn-primary" v-on:click="create_fields_instance()">Update</button>
			</div>
		</div>
	</div>
</script>

<script>
	Vue.component('template-edit',{
		template: '#template-edit',
		props: [],
		components: {
			// Use the <ckeditor> component in this view.
			ckeditor: CKEditor.component
		},
		data: function () {
			return {
				id: 0,
				menu: [],
				menu_item: {fields:[]},
				fields_instance: {},
				errors: {},
				is_loading: false,
				editor: ClassicEditor,
				editorConfig: {
					extraPlugins: [ MyCustomUploadAdapterPlugin ],
				},
				relationships: {},
			}
		},
		methods: {
			unprepare_fields: function(fields){

				this.menu_item.fields.forEach((field)=>{

					if ((field.type == 'gallery' || field.type == 'translater') && fields[field.db_title]) {
						
						fields[field.db_title] = JSON.parse(fields[field.db_title])
					}
				})

				return fields
			},
			prepare_fields: function(fields_instance){
				
				var prepared_field_instance = Object.assign({}, fields_instance)

				this.menu_item.fields.forEach((field)=>{

					if (field.type == 'gallery' || field.type == 'translater') {
						prepared_field_instance[field.db_title] = JSON.stringify(fields_instance[field.db_title])
					}
				})

				return prepared_field_instance
			},
			create_fields_instance: function(){

				this.check_fields(()=>{

					var fields = this.prepare_fields(this.fields_instance)

					request('/admin/db-insert-or-update-row', {
						table_name: this.menu_item.table_name,
						fields: JSON.stringify(fields),
						language: (this.menu_item.multilanguage == 0) ? '' : app.get_language().tag,
						id: this.id,
					}, (data)=>{
						if (data == 'Success') {
							this.$router.push('/admin/' + this.menu_item.table_name)
						} else {
							alert('Error. Press OK to reload page')
							location.reload()
						}
					})
				})            
			},
			check_fields: function(callback){

				this.menu_item.fields.forEach((field)=>{

					check_required(this.errors, this.fields_instance, field)
					check_type(this.errors, this.fields_instance, field)
				})

				var is_valid = true
				this.menu_item.fields.forEach((field)=>{

					if (this.errors[field.db_title] != '')
						is_valid = false
				})


				if (is_valid)
					callback()

				function check_required(errors, instance, field) {

					if (instance[field.db_title] == undefined && field.required == 'optional') {
						if (field.type == 'relationship' && field.relationship_count == 'single' && instance['id_' + field.relationship_table_name] == undefined)
							instance['id_' + field.relationship_table_name] = 0
						else if (field.type != 'relationship') {
							instance[field.db_title] = get_standart_val(field.type)
						}
					}
					
					if (field.required != 'optional' && instance[field.db_title] == '') {
						errors[field.db_title] = 'This field is required'
					} else if (field.required == 'required_once') {
						// TODO
					}

					function get_standart_val(type) {
						// TODO: enum, relationship
						if (type == 'checkbox' || type == 'money' || type == 'number') return 0
						if (type == 'color') return '#000000'
						if (type == 'date') return '2000-00-00'
						if (type == 'datetime') return '2000-00-00 12:00:00'
						if (type == 'gallery') return []
						if (type == 'translater') return {}
						if (type == 'repeat') return ''
						return ''
					}
				}

				function check_type(errors, instance, field) {
					
					if (field.type == 'text') {
						if (instance[field.db_title].length > 191)
							errors[field.db_title] = 'More than maxlength (191 symbols)'
					} else if (field.type == 'number' || field.type == 'money') {
						if (!$.isNumeric(instance[field.db_title]))
							errors[field.db_title] = 'Field must be numeric. Use "." instead of ","'
					}
				}
			},
			add_photo: function(id){

				window.open('/laravel-filemanager?type=image', 'FileManager', 'width=900,height=600');
				window.SetUrl = (items)=>{

					for (var i = 0; i < items.length; i++) {

						var url = items[i].url.replace(document.location.origin, '')

						this.fields_instance[id] = url
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

						this.fields_instance[id] = url
						this.$forceUpdate()

						break;
					}
				};
			},
			add_gallery: function(id){
				window.open('/laravel-filemanager?type=image', 'FileManager', 'width=900,height=600');
				window.SetUrl = (items)=>{

					if (this.fields_instance[id])
						var arr = this.fields_instance[id]
					else  var arr = []
					
					for (var i = 0; i < items.length; i++) {

						var url = items[i].url.replace(document.location.origin, '')
						arr.push(url)
					}
					this.fields_instance[id] = arr
					this.$forceUpdate()
				};
			},
			remove_gallery: function(id, index){
				this.fields_instance[id].splice(index, 1)
				this.$forceUpdate()
			},
			init_date: function(){
				
				var app = this
				$(".datepicker").each((i, elm)=>{

					var id = $(elm).attr('id')
					var today = new Date()
					var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate()

					if (app.fields_instance[id] != undefined && app.fields_instance[id] != '')
						date = app.fields_instance[id]
					else app.fields_instance[id] = date

					if ($(elm).attr('data-init') == "0") {

						$(elm).datepicker({
							dateFormat: "yy-mm-dd",
							onSelect: function(text) {
								app.fields_instance[id] = text
							}
						})
						$(elm).attr('data-init', '1')
					}
					
					$(elm).datepicker( "setDate", date );
				})
			},
			init_color: function(){

				var app = this
				$(".colorpicker").each((i, elm)=>{

					var id = $(elm).attr('id')
					var c = '#000000'

					if (app.fields_instance[id] != undefined && app.fields_instance[id] != '')
						c = app.fields_instance[id]

					$(elm).spectrum({
						color: c,
						change: function(color) {
							var hex = color.toHexString()
							app.fields_instance[id] = hex
						}
					})
				})
			},
			init_enum: function(){

				this.menu_item.fields.forEach((field)=>{

					if (field.type == 'enum') {
						if (field.enum.length > 0)
							this.fields_instance[field.db_title] = field.enum[0]
					}
				})
			},
			get_relationships: function(stack, callback){
				
				request('/admin/db-relationships', {
					language: app.get_language().tag,
					fields: JSON.stringify(stack)
				}, (data)=>{

					for (var i in data) {
						Vue.set(this.relationships, i, data[i])
					}
					callback()
				})
			},
			add_relationship_field: function(field){

				var relationships = this.relationships[field.relationship_table_name]

				var add = {}

				if (relationships.length > 0)
					add[field.relationship_table_name] = relationships[0].id
				else add[field.relationship_table_name] = 0

				this.fields_instance['$' + this.menu_item.table_name + '_' + field.relationship_table_name].push(add)
				this.$forceUpdate()
			},
			remove_relationship_field: function(field, id){
				
				this.fields_instance['$' + this.menu_item.table_name + '_' + field.relationship_table_name].splice(id, 1)
				this.$forceUpdate()
			},
			test: function(param1){
				console.log(this.fields_instance[param1])
				console.log(JSON.stringify(this.fields_instance))
			},
			refresh: function(){

				var stack = []

				this.menu_item.fields.forEach((field)=>{

					Vue.set(this.errors, field.db_title, '')

					if (field.type == 'relationship') {
						
						stack.push(field)
					
						if (field.relationship_count == 'many') {
							this.fields_instance['$' + this.menu_item.table_name + '_' + field.relationship_table_name] = []
						}

					}
				})

				this.get_relationships(stack, ()=>{
					
					if (this.id != 0) {

						this.is_loading = true

						var rels = []
						for (i in this.menu_item.fields) {
							var field = this.menu_item.fields[i]
							if (field.relationship_count == 'many')
								rels.push([this.id, this.menu_item.table_name + '_' + field.relationship_table_name, field.relationship_table_name])
						}
						if (rels.length > 0) rels = JSON.stringify(rels)
						else rels = ''
						
						request('/admin/db-select', {
							table: this.menu_item.table_name,
							where: 'id=' + this.id,
							language: (this.menu_item.multilanguage == 0) ? '' : app.get_language().tag,
							relationships: rels,
							limit: 1,
						}, (data)=>{
							this.is_loading = false
							this.fields_instance = this.unprepare_fields(data[0])
							this.init_color()
							this.init_date()
						})
					} else {
						this.init_color()
						this.init_date()
						this.init_enum()
					}
				})
			},
			find_menu_elm: function(){
				for(var i = 0, length = this.menu.length; i < length; i++){
					if (this.menu[i].table_name == this.$route.params.table_name) {
						this.menu_item = this.menu[i]
						break
					}
				}

				if (this.$route.params.edit_id)
					this.id = this.$route.params.edit_id
			},
		},
		watch: {
			'$route.params.table_name': function(){
				this.find_menu_elm()
			},
			'$route.params.edit_id': function(){
				this.find_menu_elm()
			},
		},
		created: function(){
			if (app) {
				this.menu = app.menu
				this.find_menu_elm()
				this.refresh()
			} else {
				this.$root.$on('menu_init',(menu)=>{
					this.menu = menu
					this.find_menu_elm()
					this.refresh()
				})
			}
		},
		beforeDestroy: function(){
			this.$root.$off('menu_init')
		},
	})
</script>