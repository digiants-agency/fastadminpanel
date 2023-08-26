<script type="text/x-template" id="template-index">
	<div class="index">
		<div class="space-between">
			<h1 v-text="this.menu_item.title"></h1>
			
			<ul class="edit-settings">
				<li>
					<div class="edit-settings-dots">...</div>
					<ul class="edit-settings-options">
						<li class="edit-settings-option">
							<router-link :to="'/admin/import/' + menu_item.table_name">{{ __('fastadminpanel.import_xlsx') }}</router-link>
						</li>
						<li class="edit-settings-option">
							<a :href="'/admin/export/' + menu_item.table_name">{{ __('fastadminpanel.export_xlsx') }}</a>
						</li>
					</ul>
				</li>
			</ul>

		</div>
		<div class="index">
			<div class="index-body">
				<div class="index-title">{{ __('fastadminpanel.list') }}</div>
				<router-link :to="'/admin/' + menu_item.table_name + '/create'" class="btn btn-add">
					{{ __('fastadminpanel.add') }}
				</router-link>
				<div id="datatable_wrapper">
					<div id="datatable_filter">
						<div class="datatables-sort">
							<label>
								<span>{{ __('fastadminpanel.sort') }}</span>
								<div class="select-wrapper">
									<select v-on:change="get_fields_instances" v-model="order">
										<option v-for="field in menu_item.fields" v-if="field.show_in_list != 'no'" :value="field.db_title" v-text="field.title"></option>
									</select>

									<div class="select-arrow-block">
										<svg class="select-arrow" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
											<clipPath id="clip0_755_2893">
											<rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
											</clipPath>
										</svg>
									</div>
								</div>
								<div class="select-wrapper">
									<select v-on:change="get_fields_instances" v-model="sort_order">
										<option value="DESC">{{ __('fastadminpanel.asc') }}</option>
										<option value="ASC">{{ __('fastadminpanel.desc') }}</option>
									</select>

									<div class="select-arrow-block">
										<svg class="select-arrow" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
											<clipPath id="clip0_755_2893">
											<rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
											</clipPath>
										</svg>
									</div>
								</div>
							</label>
						</div>
						<label class="index-search-wrapper">
							{{ __('fastadminpanel.search') }}
							<input class="index-search" type="text" v-model="search">
							<svg class="index-search-icon" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M13.9145 13.0897L9.84765 9.0228C10.619 8.0705 11.0833 6.85982 11.0833 5.54169C11.0833 2.48602 8.59733 0 5.54166 0C2.48599 0 0 2.48602 0 5.54169C0 8.59736 2.48602 11.0834 5.54169 11.0834C6.85982 11.0834 8.0705 10.619 9.0228 9.84768L13.0897 13.9146C13.2036 14.0285 13.3883 14.0285 13.5022 13.9146L13.9146 13.5022C14.0285 13.3883 14.0285 13.2036 13.9145 13.0897ZM5.54169 9.9167C3.12917 9.9167 1.16668 7.9542 1.16668 5.54169C1.16668 3.12917 3.12917 1.16668 5.54169 1.16668C7.9542 1.16668 9.91669 3.12917 9.91669 5.54169C9.91669 7.9542 7.9542 9.9167 5.54169 9.9167Z" fill="#51225D"/>
							</svg>
						</label>
					</div>

					<div class="datatable-wrapper">
						<table class="table table-striped table-hover table-responsive datatable dataTable no-footer">
							<thead>
								<tr>
									<th class="sorting_asc flex0">
										<label class="checkbox">
											<input class="checkbox-input" v-on:change="set_marked($event.target.checked)" style="display: none;" type="checkbox">
											<div class="checkbox-rectangle">
												<svg class="checkbox-mark" enable-background="new 0 0 515.556 515.556" height="512" viewBox="0 0 515.556 515.556" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m0 274.226 176.549 176.886 339.007-338.672-48.67-47.997-290.337 290-128.553-128.552z" fill="white"/></svg>
											</div>
										</label>
									</th>
									<th class="sorting" v-for="field in menu_item.fields" v-if="field.show_in_list != 'no'" :class="{'flex0': field.show_in_list == 'editable' && field.type == 'checkbox'}" v-text="field.title"></th>
									<th class="sorting">&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="instance in instances" class="datatable-tr">
									<td class="td-content flex0">
										<div class="td-content-conteiner">
											<label class="checkbox">
												<input class="checkbox-input" v-on:change="instance.marked = $event.target.checked" :checked="instance.marked" style="display: none;" type="checkbox">
												<div class="checkbox-rectangle">
													<svg class="checkbox-mark" enable-background="new 0 0 515.556 515.556" height="512" viewBox="0 0 515.556 515.556" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m0 274.226 176.549 176.886 339.007-338.672-48.67-47.997-290.337 290-128.553-128.552z" fill="white"/></svg>
												</div>
											</label>
										</div>
									</td>
									<td class="td-content" v-for="field in menu_item.fields" v-if="field.show_in_list != 'no'" :class="{'flex0': field.show_in_list == 'editable' && field.type == 'checkbox'}">
										<div class="td-content-conteiner">
											
											<span v-if="field.show_in_list == 'yes' && field.type == 'relationship' && field.relationship_count == 'single'" v-text="instance[field.relationship_table_name + '_' + field.relationship_view_field]"></span>
											<input class="form-control editable-input" :class="{saving: false, saved: false}" type="text" v-on:change="editable_change($event.target.value, instance, field)" v-model="instance[field.db_title]" v-else-if="field.show_in_list == 'editable' && (field.type == 'number' || field.type == 'text' || field.type == 'textarea')">
											<label class="checkbox editable-checkbox" v-else-if="field.show_in_list == 'editable' && field.type == 'checkbox'">
												<input class="checkbox-input" :class="{saving: false, saved: false}" v-on:change="editable_change($event.target.checked, instance, field)" v-model="instance[field.db_title]" style="display: none;" type="checkbox">
												<div class="checkbox-rectangle">
													<svg class="checkbox-mark" enable-background="new 0 0 515.556 515.556" height="512" viewBox="0 0 515.556 515.556" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m0 274.226 176.549 176.886 339.007-338.672-48.67-47.997-290.337 290-128.553-128.552z" fill="white"/></svg>
												</div>
											</label>
											<span v-text="instance[field.db_title]" v-else></span>
										</div>
									</td>
									<td class="td-actions">
										<div class="td-content-conteiner td-actions-container">

											<router-link :to="'/admin/' + menu_item.table_name + '/edit/' + instance.id" class="btn btn-small btn-blue btn-with-tip">
												<svg class="btn-svg" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M4.23649 10.499L1.51468 7.77721L8.09785 1.19404L10.8197 3.91585L4.23649 10.499ZM1.26026 8.25666L3.75704 10.7534L0.0136719 12L1.26026 8.25666ZM11.6568 3.0823L11.1847 3.55439L8.45931 0.828983L8.93141 0.356884C9.40696 -0.118961 10.1781 -0.118961 10.6537 0.356884L11.6568 1.36C12.1289 1.83715 12.1289 2.6053 11.6568 3.0823Z" fill="black"/>
													<clipPath id="clip0_754_1317">
													<rect width="12" height="12" fill="white"/>
													</clipPath>
												</svg>
												<div class="btn-tooltip">{{ __('fastadminpanel.edit') }}</div>
											</router-link>
											
											<div class="btn btn-small btn-blue td-actions-delete btn-with-tip" v-on:click="copy(instance.id)" >
												<svg class="btn-svg" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M7.13278 2.25003C8.30429 2.25003 9.25781 3.20355 9.25781 4.37506V9.5H10.1328C10.8913 9.5 11.5078 8.88358 11.5078 8.12506V1.37506C11.5078 0.616547 10.8913 3.05176e-05 10.1328 3.05176e-05H3.88284C3.12433 3.05176e-05 2.50781 0.616547 2.50781 1.37506V2.25003H7.13278Z" fill="black"/>
													<path d="M0.507843 10.625C0.507843 11.3845 1.12335 12 1.88278 12H7.13278C7.8923 12 8.50781 11.3845 8.50781 10.625V4.37503C8.50781 3.61551 7.8923 3 7.13278 3H1.88278C1.12335 3 0.507843 3.61551 0.507843 4.37503V10.625Z" fill="black"/>
												</svg>
												<div class="btn-tooltip">{{ __('fastadminpanel.copy') }}</div>
											</div>
											
											<div class="btn btn-small btn-danger td-actions-delete btn-with-tip" v-on:click="remove_row(instance.id)">
												<svg class="btn-svg" width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M4.88111 4.00017L7.8722 1.00895C7.95447 0.926606 7.99987 0.816752 8 0.699614C8 0.582411 7.9546 0.472427 7.8722 0.390216L7.61008 0.128167C7.52767 0.0456305 7.41782 0.000427246 7.30055 0.000427246C7.18348 0.000427246 7.07363 0.0456305 6.99122 0.128167L4.00013 3.11919L1.00891 0.128167C0.926634 0.0456305 0.816715 0.000427246 0.699512 0.000427246C0.582439 0.000427246 0.47252 0.0456305 0.390244 0.128167L0.128 0.390216C-0.0426667 0.560883 -0.0426667 0.838476 0.128 1.00895L3.11915 4.00017L0.128 6.99126C0.0456585 7.07373 0.000325203 7.18358 0.000325203 7.30072C0.000325203 7.41786 0.0456585 7.52771 0.128 7.61012L0.390179 7.87217C0.472455 7.95464 0.582439 7.99991 0.699447 7.99991C0.81665 7.99991 0.926569 7.95464 1.00885 7.87217L4.00006 4.88108L6.99115 7.87217C7.07356 7.95464 7.18341 7.99991 7.30049 7.99991H7.30062C7.41776 7.99991 7.52761 7.95464 7.61002 7.87217L7.87213 7.61012C7.95441 7.52778 7.9998 7.41786 7.9998 7.30072C7.9998 7.18358 7.95441 7.07373 7.87213 6.99132L4.88111 4.00017Z" fill="#F8F9FB"/>
												</svg>
												<div class="btn-tooltip">{{ __('fastadminpanel.delete') }}</div>
											</div>

										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="index-pagination">
						<div class="index-pagination-btns">
							<div class="index-pagination-number index-pagination-prev" onselectstart="return false" :class="{'disabled': curr_page == 1}" v-on:click="prev_page()">
								<svg class="index-pagination-svg" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M2.90317 5.67074L8.44429 0.129616C8.62773 -0.0475487 8.92005 -0.0424621 9.09721 0.140979C9.27005 0.31993 9.27005 0.603615 9.09721 0.782538L3.88255 5.9972L9.09721 11.2119C9.27749 11.3922 9.27749 11.6845 9.09721 11.8648C8.91688 12.0451 8.6246 12.0451 8.44429 11.8648L2.90317 6.32366C2.72289 6.14333 2.72289 5.85105 2.90317 5.67074Z" fill="#171219"/>
									<clipPath id="clip0_754_1492">
									<rect width="12" height="12" fill="white" transform="matrix(-1 0 0 1 12 0)"/>
									</clipPath>
								</svg>
							</div>
							<div class="index-pagination-numbers">
								<div class="index-pagination-number" v-if="pages_count < 5 || (i == 1 || i == pages_count || i == curr_page)" v-on:click="curr_page = i" :class="{'active': i == curr_page}" v-for="i in pages_count" v-text="i"></div>
								<div class="index-pagination-number" v-else-if="i == curr_page - 1 || i == curr_page + 1">...</div>
							</div>
							<div class="index-pagination-number index-pagination-next" onselectstart="return false" :class="{'disabled': curr_page == pages_count}" v-on:click="next_page()">
								<svg class="index-pagination-svg" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M9.09683 5.67074L3.55571 0.129616C3.37227 -0.0475487 3.07995 -0.0424621 2.90279 0.140979C2.72995 0.31993 2.72995 0.603615 2.90279 0.782538L8.11745 5.9972L2.90279 11.2119C2.72251 11.3922 2.72251 11.6845 2.90279 11.8648C3.08312 12.0451 3.3754 12.0451 3.55571 11.8648L9.09683 6.32366C9.27711 6.14333 9.27711 5.85105 9.09683 5.67074Z" fill="#171219"/>
									<clipPath id="clip0_754_1486">
									<rect width="12" height="12" fill="white"/>
									</clipPath>
								</svg>
							</div>
						</div>
						<div class="index-pagination-show">{{ __('fastadminpanel.showing') }} <span v-text="(offset + 1)"></span> {{ __('fastadminpanel.to') }} <span v-text="(offset + instances.length)"></span> <span v-if="count > 0">{{ __('fastadminpanel.of') }} <span v-text="count"></span> {{ __('fastadminpanel.entries') }}</span></div>

					</div>
				</div>
				<div class="mass-delete-col">
					<button class="btn btn-danger" v-on:click="delete_checked">
						{{ __('fastadminpanel.delete_checked') }}
					</button>
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
			copy: async function(id){
				request('/admin/db-copy', {
					id: id,
					language: (this.menu_item.multilanguage == 0) ? '' : app.get_language().tag,
					table: this.menu_item.table_name,
				}, (data)=>{
					this.refresh()
				})
			},
			editable_change: async function(val, instance, field){
				
				var value = val
				if (field.type == 'number')
					value = parseInt(value)
				else if (field.type == 'checkbox')
					value = value ? 1 : 0

				await post('/admin/save-editable', {
					table: this.menu_item.table_name,
					id: instance.id,
					field: field.db_title,
					value: value,
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
							
							if (field.type == 'relationship' && field.relationship_count == 'single') {

								where_arr.push(this.get_search_table_relation(field.relationship_table_name) + '.' + field.relationship_view_field + ' LIKE "%' + this.search + '%"')

							} else {
								
								where_arr.push(this.get_search_table_menu() + '.' + field.db_title + ' LIKE "%' + this.search + '%"')
							}
						}
					}
					where = where_arr.join(' OR ')
				}

				var select = this.get_search_table_menu() + '.*'
				
				var join = []
				for (var i = this.menu_item.fields.length - 1; i >= 0; i--) {

					var field = this.menu_item.fields[i]

					if (field.show_in_list == 'yes' && field.type == 'relationship' && field.relationship_count == 'single') {

						let field_relationship_table_name = this.get_search_table_relation(field.relationship_table_name)

						join.push({
							short: field.relationship_table_name,
							full: field_relationship_table_name,
						})
						select += ', ' + field_relationship_table_name + '.' + field.relationship_view_field + ' AS ' + 
							field.relationship_table_name + '_' + field.relationship_view_field
					}
				}

				request('/admin/db-select', {
					table: this.menu_item.table_name,
					fields: select,
					join: join.length == 0 ? '' : JSON.stringify(join),
					order: this.order,
					sort_order: this.sort_order,
					offset: this.offset,
					language: (this.menu_item.multilanguage == 0) ? '' : app.get_language().tag,
					where: where,
					limit: 10,
				}, (data)=>{

					data.instances.forEach((elm)=>{
						elm.marked = false
					})

					this.instances = data.instances
					this.count = data.count
				})
			},
			get_search_table_menu: function(){
				if (this.menu_item.multilanguage == 0) {
					return this.menu_item.table_name
				} else {
					return this.menu_item.table_name + '_' + app.get_language().tag
				}
			},
			get_search_table_relation: function(relation_table){
				let table = relation_table
				for (var j = 0; j < this.menu.length; j++) {
					if (this.menu[j].table_name == relation_table) {
						if (this.menu[j].multilanguage == 1)
							table += '_' + app.get_language().tag
						break
					}
				}
				return table
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
				this.get_fields_instances()

			},
			init: function(menu_item){
				this.menu_item = menu_item
				this.order = this.get_order()
				this.offset = 0
				this.get_fields_instances()
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
					this.curr_page = 1
					// this.refresh()
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