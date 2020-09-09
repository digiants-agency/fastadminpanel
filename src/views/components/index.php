<script type="text/x-template" id="template-index">
	<div class="index">
		<div >
			<router-link :to="'/admin/' + menu_item.table_name + '/create'" class="btn btn-info">
				Add new
			</router-link>
			<div class="portlet box green">
				<div class="portlet-title">
					<div class="caption">List</div>
				</div>
				<div class="portlet-body">
					<div id="datatable_wrapper">
						<div id="datatable_filter">
							<div class="datatables-sort">
								<label>Sort by 
									<select v-on:change="get_fields_instances" v-model="order">
										<option v-for="field in menu_item.fields" v-if="field.show_in_list != 'no'" :value="field.db_title" v-text="field.title"></option>
									</select>
									<select v-on:change="get_fields_instances" v-model="sort_order">
										<option value="DESC">Descending</option>
										<option value="ASC">Ascending</option>
									</select>
								</label>
							</div>
							<label>
								Search:<input type="search" v-model="search">
							</label>
						</div>
						<table class="table table-striped table-hover table-responsive datatable dataTable no-footer">
							<thead>
								<tr>
									<th class="sorting_asc">
										<input type="checkbox" v-on:click="set_marked($event.target.checked)">
									</th>
									<th class="sorting" v-for="field in menu_item.fields" v-if="field.show_in_list != 'no'" v-text="field.title"></th>
									<th class="sorting">&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="instance in instances">
									<td class="td-content">
										<input type="checkbox" v-on:change="instance.marked = $event.target.checked" :checked="instance.marked">
									</td>
									<td class="td-content" v-for="field in menu_item.fields" v-if="field.show_in_list != 'no'">
										<input class="form-control editable-input" :class="{saving: false, saved: false}" type="text" v-on:change="editable_change($event.target.value, instance, field)" v-model="instance[field.db_title]" v-if="field.show_in_list == 'editable' && (field.type == 'number' || field.type == 'text' || field.type == 'textarea')">
										<span v-text="instance[field.db_title]" v-else></span>
									</td>
									<td class="td-actions">
										<router-link :to="'/admin/' + menu_item.table_name + '/edit/' + instance.id" class="btn btn-xs btn-info">Edit</router-link>
										<div class="btn btn-xs btn-danger td-actions-delete" v-on:click="remove_row(instance.id)">Delete</div>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="index-pagination">
							<div class="index-pagination-show">Showing <span v-text="(offset + 1)"></span> to <span v-text="(offset + instances.length)"></span> <span v-if="count > 0">of <span v-text="count"></span> entries</span></div>
							<div class="index-pagination-btns">
								<div class="index-pagination-prev" onselectstart="return false" :class="{'disabled': curr_page == 1, 'active': curr_page != 1 && pages_count > 1}" v-on:click="prev_page()">Previous</div>
								<div class="index-pagination-numbers">
									<div class="index-pagination-number" v-if="pages_count < 5 || (i == 1 || i == pages_count || i == curr_page)" v-on:click="curr_page = i" :class="{'active': i == curr_page}" v-for="i in pages_count" v-text="i"></div>
									<div class="index-pagination-number" v-else-if="i == curr_page - 1 || i == curr_page + 1">...</div>
								</div>
								<div class="index-pagination-next" onselectstart="return false" :class="{'disabled': curr_page == pages_count, 'active': curr_page != pages_count && pages_count > 1}" v-on:click="next_page()">Next</div>
							</div>
						</div>
					</div>
					<div class="mass-delete-col">
						<button class="btn btn-danger" v-on:click="delete_checked">
							Delete checked
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>

<script>
	Vue.component('template-index',{
		template: '#template-index',
		data: function () {
			return {
				menu: [],
				menu_item: {},
				order: '',
				sort_order: 'DESC',
				count: 0,
				offset: 0,
				instances: [],
				search_timeout: null,
				search: '',
			}
		},
		methods: {
			editable_change: function(val, instance, field){

				var table = this.menu_item.table_name

				if (this.menu_item.multilanguage == 1) {
					table += '_' + app.get_language().tag
				}
				
				var value = val
				if (field.type == 'number')
					value = parseInt(value)

				request('/admin/db-update', {
					table: table,
					id: instance.id,
					field: field.db_title,
					value: value,
				}, (data)=>{
					
				}, (data)=>{

				})
			},
			remove_row: function(id){

				if (confirm("Are you sure?")) {
					
					request('/admin/db-remove-row', {
						table_name: this.menu_item.table_name,
						language: (this.menu_item.multilanguage == 0) ? '' : app.get_language().tag,
						id: id,
					}, (data)=>{
						if (data == 'Success') {
							this.refresh()
						} else {
							alert('Error. Press OK to reload page')
							location.reload()
						}
					})
				}
			},
			get_fields_instances: function(){

				var where = ''

				if (this.search.length > 1) {

					var where_arr = []

					for (var i = 0; i < this.menu_item.fields.length; i++) {

						var field = this.menu_item.fields[i]

						if (field.show_in_list != 'no') {
							
							where_arr.push(field.db_title + ' LIKE "%' + this.search + '%"')
						}
					}
					where = where_arr.join(' OR ')
				}
				
				request('/admin/db-select', {
					table: this.menu_item.table_name,
					order: this.order,
					sort_order: this.sort_order,
					offset: this.offset,
					language: (this.menu_item.multilanguage == 0) ? '' : app.get_language().tag,
					where: where,
					limit: 10,
				}, (data)=>{

					data.forEach((elm)=>{
						elm.marked = false
					})

					this.instances = data
				})
			},
			get_count: function(){
				request('/admin/db-count', {
					table: this.menu_item.table_name,
					language: (this.menu_item.multilanguage == 0) ? '' : '_' + app.get_language().tag,
				}, (data)=>{
					this.count = data
					this.get_fields_instances()
				})
			},
			prev_page: function(){
				if (this.curr_page != 1 && this.pages_count > 1)
					this.curr_page--
			},
			next_page: function(){
				if (this.curr_page != this.pages_count && this.pages_count > 1)
					this.curr_page++
			},
			delete_checked: function(){

				if (confirm("Are you sure?")) {

					var ids = []

					this.instances.forEach((elm)=>{
						if (elm.marked)
							ids.push(elm.id)
					})
					
					request('/admin/db-remove-rows', {
						table_name: this.menu_item.table_name,
						language: (this.menu_item.multilanguage == 0) ? '' : app.get_language().tag,
						ids: JSON.stringify(ids),
					}, (data)=>{
						if (data == 'Success') {
							this.refresh()
						} else {
							alert('Error. Press OK to reload page')
							location.reload()
						}
					})
				}
			},
			set_marked: function(is_mark){
				this.instances.forEach((elm)=>{
					elm.marked = is_mark
				})
			},
			refresh: function(){
				// TODO: make only one request
				this.get_count()
			},
			init: function(menu_item){
				this.menu_item = menu_item
				this.order = this.get_order()
				this.offset = 0
				this.get_count()
			},
			get_order: function(){
				var order = ''
				for (var i = 0; i < this.menu_item.fields.length; i++) {
					if (this.menu_item.fields[i].show_in_list != 'no') {
						order = this.menu_item.fields[i].db_title
						break
					}
				}
				// check date
				for (var i = 0; i < this.menu_item.fields.length; i++) {
					if (this.menu_item.fields[i].show_in_list != 'no' && this.menu_item.fields[i].db_title == 'date') {
						order = this.menu_item.fields[i].db_title
						break
					}
				}
				return order
			},
			find_menu_elm: function(){
				for(var i = 0, length = this.menu.length; i < length; i++){
					if (this.menu[i].table_name == this.$route.params.table_name) {
						this.init(this.menu[i])
						break
					}
				}
			},
		},
		computed: {
			pages_count: function(){
				return Math.ceil(this.count / 10)
			},
			curr_page: {
				get: function(){
					return parseInt(this.offset / 10) + 1
				},
				set: function(newValue){
					// console.log('set curr_page')
					this.offset = (newValue - 1) * 10
					this.get_fields_instances()
				},
			},
		},
		watch: {
			'$route.params.table_name': function(table_name){
				this.find_menu_elm()
			},
			search: function(val){

				if (this.search_timeout != null) clearTimeout(this.search_timeout)

				this.search_timeout = setTimeout(()=>{
					
					this.refresh()
				}, 500)
			},
		},
		created: function(){
			if (app) {
				this.menu = app.menu
				this.find_menu_elm()
			} else {
				this.$root.$on('menu_init',(menu)=>{
					this.menu = menu
					this.find_menu_elm()
				})
			}

			this.$root.$on('set_language', (lang)=>{
				this.refresh()
			})
		},
		beforeDestroy: function(){
			this.$root.$off('menu_init')
			this.$root.$off('set_language')
		},
	})
</script>