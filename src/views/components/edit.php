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
		<div v-for="(field, index) in fields" v-if="field.is_visible">
			<component <?php /*:name="field.db_table"*/ ?> :is="'template-field-' + field.type" ref="refield" :field="field" :table_name="menu_item.table_name"></component>
		</div>
		<div class="row form-group">
			<label class="col-sm-2 control-label"></label>
			<div class="col-sm-10">
				<button v-if="id == 0" class="btn btn-primary" v-on:click="save(true)">Create</button>
				<template v-else>
					<button class="btn btn-primary" v-on:click="save(false)">Update</button>
					<button class="btn btn-primary" v-on:click="save(true)">Update and close</button>
				</template>
			</div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-edit',{
		template: '#template-edit',
		props: [],
		data: function () {
			return {
				id: 0,
				menu: [],
				menu_item: {table_name: ''},
				fields: [],
			}
		},
		methods: {
			filter_fields: function(fields){
				const filtered_fields = []
				for (let field of fields){
					if (field.type == "relationship" && field.relationship_count != "editable") {

						filtered_fields.push({
							type: field.type,
							relationship_count: field.relationship_count,
							relationship_table_name: field.relationship_table_name,
							lang: field.lang,
							db_title: field.db_title,
							value: field.value,
						})

					} else if (field.type == "relationship" && field.relationship_count == "editable") {

						const fields_editable = []
						for (let values of field.value){
							fields_editable.push({
								fields: this.filter_fields(values.fields), 
								id: values.id
							})
						}

						filtered_fields.push({
							type: field.type,
							relationship_count: field.relationship_count,
							lang: field.lang,
							relationship_table_name: field.relationship_table_name,
							db_title: field.db_title,
							value: fields_editable,
						})

					} else {

						filtered_fields.push({
							type: field.type,
							lang: field.lang,
							db_title: field.db_title,
							value: field.value,
						})
					}	
				}

				return filtered_fields
			},
			save: async function(is_close){

				if (this.check_fields()) {

					const response = await post('/admin/set-dynamic', {
						table: this.menu_item.table_name,
						fields: JSON.stringify(this.filter_fields(this.fields)),
						language: app.get_language().tag,
						id: this.id,
					})

					if (!response.success) {
						alert('Error')
						return
					}

					if (is_close)
						this.$router.push('/admin/' + this.menu_item.table_name)
				}
			},
			check_fields: function(callback){
				
				let is_valid = true
				
				this.$refs.refield.forEach((field)=>{

					if (!field.check())
						is_valid = false
				})

				return is_valid
			},
			refresh: async function(){

				const response = await post('/admin/get-dynamic', {
					language: app.get_language().tag,
					table: this.menu_item.table_name,
					id: this.id,
				})

				if (!response.success) {
					alert('Error')
					return
				}

				this.fields = response.data
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