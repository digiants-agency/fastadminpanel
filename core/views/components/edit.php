<template id="template-edit">
	<div class="edit">
		<div class="">
			<router-link :to="'/admin/' + menu_item.table_name" class="btn btn-primary align-self-flex-start btn-edit">
				<svg width="9" height="10" viewBox="0 0 9 10" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M0.54038 4.54038C0.28654 4.79422 0.28654 5.20578 0.540381 5.45962L4.67696 9.59619C4.9308 9.85004 5.34235 9.85004 5.59619 9.59619C5.85004 9.34235 5.85004 8.9308 5.59619 8.67696L1.91924 5L5.59619 1.32305C5.85003 1.0692 5.85003 0.657647 5.59619 0.403807C5.34235 0.149966 4.9308 0.149966 4.67695 0.403807L0.54038 4.54038ZM9 4.35L1 4.35L1 5.65L9 5.65L9 4.35Z" fill="white"/>
				</svg>
				Назад
			</router-link>
			
			<div class="space-between">
				
				<h1 v-if="id == 0">Добавить новый</h1>
				<h1 v-else-if="menu_item.table_name == 'orders'">Данные клиента</h1> <!-- for tim -->
				<h1 v-else>Редактировать</h1>
			</div>
		</div>

		<div class="edit-fields" :class="menu_item.table_name">
			<div v-for="(field, index) in fields" v-if="field.is_visible && field.relationship_count != 'editable'" :class="'field-'+field.type">
				<component :is="'template-field-' + field.type" ref="refield" :field="field" :table_name="menu_item.table_name" :parent_hash="hash"></component>
			</div>
		</div>

		<div :class="'editable-' + menu_item.table_name" v-for="(field, index) in fields" v-if="field.is_visible && field.relationship_count == 'editable'">
			<h1 v-text="field.title"></h1>
			<div class="edit-fields edit-fields-editable">
				<component :is="'template-field-' + field.type" ref="refield" :field="field" :table_name="menu_item.table_name" ></component>
			</div>
		</div>


		<div class="edit-fields-btns">
			<button v-if="id == 0" class="btn btn-primary" v-on:click="save(true)">Создать</button>
			<template v-else>
				<button class="btn btn-primary" v-on:click="save(false)">Сохранить изменения</button>
				<button class="btn btn-primary" v-on:click="save(true)">Сохранить и закрыть</button>
			</template>
		</div>
	</div>
</template>
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
				hash: Math.random() * Date.now(),
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