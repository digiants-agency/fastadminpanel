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
		<div v-for="(field, index) in menu_item.fields" v-if="field.is_visible">
			<div class="mb-30" v-if="field.type == 'relationship' && field.relationship_count == 'editable'">
				<div class="row">
					<div class="col-sm-10 offset-2">
						<h3 v-text="field.title"></h3>
					</div>
				</div>
				<div class="mb-15" v-for="(instance, i) in fields_instance.editable[field.relationship_table_name]">
					<div v-for="(f, index) in relationships[field.relationship_table_name]">
						<template-fields-dynamic :field="f" :index="index" :fields_instance="instance" v-if="f.is_visible && f.type != 'relationship'"></template-fields-dynamic>
					</div>
					<div class="flex justify-end">
						<div class="btn btn-danger" v-on:click="fields_instance.editable[field.relationship_table_name].splice(i, 1)">Delete</div>
					</div>
				</div>
				<div class="row">
					<div class="offset-sm-2 col-sm-10">
						<div class="btn btn-primary" v-on:click="fields_instance.editable[field.relationship_table_name].push({})">Add</div>
					</div>
				</div>
			</div>
			<template-fields-dynamic :field="field" :index="index" :fields_instance="fields_instance" :relationships="relationships" :table_name="menu_item.table_name" v-else></template-fields-dynamic>
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
				fields_instance: {editable: {}},
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
						var edits = []
						for (i in this.menu_item.fields) {
							var field = this.menu_item.fields[i]
							if (field.relationship_count == 'many') {
							
								rels.push({
									id: this.id,
									rel: this.menu_item.table_name + '_' + field.relationship_table_name,
									table: field.relationship_table_name,
								})

							} else if (field.relationship_count == 'editable') {

								edits.push({
									id: this.id,
									table: field.relationship_table_name,
								})
							}
						}
						if (rels.length > 0) rels = JSON.stringify(rels)
						else rels = ''
						if (edits.length > 0) edits = JSON.stringify(edits)
						else edits = ''
						
						request('/admin/db-select', {
							table: this.menu_item.table_name,
							where: 'id=' + this.id,
							language: (this.menu_item.multilanguage == 0) ? '' : app.get_language().tag,
							relationships: rels,
							editables: edits,
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

						for (let f of this.menu_item.fields) {
							if (f.type == 'relationship' && f.relationship_count == 'editable') {
								Vue.set(this.fields_instance.editable, f.relationship_table_name, [])
							}
						}
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