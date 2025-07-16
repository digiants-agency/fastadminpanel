<template id="crud-entities">
	<div class="index">
		<div class="space-between">
			<h1 v-text="title"></h1>
			<ul class="edit-settings">
				<li>
					<div class="edit-settings-dots">...</div>
					<ul class="edit-settings-options">
						<li class="edit-settings-option">
							<router-link :to="{name: 'crudsEntitiesImport', params: {table: table}}">
								{{ __('fastadminpanel.import_xlsx') }}
							</router-link>
						</li>
						<li class="edit-settings-option">
							<a :href="'{{ route('admin-api-export', ['table' => 'table'], false) }}'.replace('table', table)">
								{{ __('fastadminpanel.export_xlsx') }}
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
		<div class="index">
			<div class="index-body">
				<div class="index-title">
					{{ __('fastadminpanel.list') }}
				</div>
				<router-link 
					v-if="rolesStore.can(table, 'admin_edit')" 
					:to="{name: 'crudsEntity', params: {table: table, id: 'create'}}" 
					class="btn btn-add">
					{{ __('fastadminpanel.add') }}
				</router-link>
				<div id="datatable_wrapper">
					<div id="datatable_filter">
						<div class="datatables-sort">
							<label>
								<span>{{ __('fastadminpanel.sort') }}</span>
								<div class="select-wrapper">
									<select v-model="order" v-on:change="fetchFieldInstances">
										<option :value="'id'">ID</option>
										<option 
											v-for="field in fields.filter(f => f.show_in_list != 'no' && f.db_title)"
											:value="field.db_title" 
											v-text="field.title"
										></option>
									</select>
									<div class="select-arrow-block">
										<img class="select-arrow" src="/vendor/fastadminpanel/images/dropdown-ico.svg" alt="">
									</div>
								</div>
								<div class="select-wrapper">
									<select v-model="sort">
										<option value="DESC">{{ __('fastadminpanel.desc') }}</option>
										<option value="ASC">{{ __('fastadminpanel.asc') }}</option>
									</select>
									<div class="select-arrow-block">
										<img class="select-arrow" src="/vendor/fastadminpanel/images/dropdown-ico.svg" alt="">
									</div>
								</div>
								<div class="select-wrapper">
									<select v-model="perPage">
										<option :value="10">10</option>
										<option :value="20">20</option>
										<option :value="30">30</option>
										<option :value="50">50</option>
										<option :value="100">100</option>
									</select>
									<div class="select-arrow-block">
										<img class="select-arrow" src="/vendor/fastadminpanel/images/dropdown-ico.svg" alt="">
									</div>
								</div>
							</label>
						</div>
						<label class="index-search-wrapper">
							{{ __('fastadminpanel.search') }}
							<input class="index-search" type="text" v-model="search">
							<img class="index-search-icon" src="/vendor/fastadminpanel/images/search-ico.svg" alt="">
						</label>
					</div>
					<div class="datatable-wrapper">
						<table class="table table-striped table-hover table-responsive datatable dataTable no-footer">
							<thead>
								<tr>
									<th class="sorting_asc flex0">
										<label class="checkbox">
											<input class="checkbox-input" v-on:change="setMarked($event.target.checked)" style="display: none;" type="checkbox">
											<div class="checkbox-rectangle">
												<img class="checkbox-mark" src="/vendor/fastadminpanel/images/checkbox-mark.svg" alt="" />
											</div>
										</label>
									</th>
									<th 
										v-for="field in fields.filter(f => f.show_in_list != 'no')" 
										class="sorting" 
										:class="{'flex0': field.show_in_list == 'editable' && field.type == 'checkbox'}" 
										v-text="field.title"
									></th>
									<th class="sorting">&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="instance in instances" class="datatable-tr">
									<td class="td-content flex0">
										<div class="td-content-conteiner">
											<label class="checkbox">
												<input 
													class="checkbox-input" 
													:checked="instance.is_marked" 
													style="display: none;" 
													type="checkbox"
													v-on:change="instance.is_marked = $event.target.checked" 
												/>
												<div class="checkbox-rectangle">
													<img class="checkbox-mark" src="/vendor/fastadminpanel/images/checkbox-mark.svg" alt="">
												</div>
											</label>
										</div>
									</td>
									<td v-for="field in fields.filter(f => f.show_in_list != 'no')" class="td-content" :class="{'flex0': field.show_in_list == 'editable' && field.type == 'checkbox'}">
										<div class="td-content-conteiner">
											<span 
												v-if="field.show_in_list == 'yes' && field.type == 'relationship' && field.relationship_count == 'single'" 
												v-text="instance['id_' + field.relationship_table_name]">
											</span>
											<img 
												v-else-if="field.show_in_list == 'yes' && field.type == 'photo'" 
												:src="instance[field.db_title]"
												class="crud-entities-img"
											/>
											<input 
												v-else-if="field.show_in_list == 'editable' && (field.type == 'number' || field.type == 'text' || field.type == 'textarea')" 
												class="form-control editable-input" 
												:class="{saving: false, saved: false}" 
												type="text" 
												v-on:change="changeEditable($event.target.value, instance, field)" 
												v-model="instance[field.db_title]"
											/>
											<label 
												v-else-if="field.show_in_list == 'editable' && field.type == 'checkbox'" 
												class="checkbox editable-checkbox">
												<input 
													:true-value="1"
													:false-value="0"
													class="checkbox-input" 
													:class="{saving: false, saved: false}"
													type="checkbox"
													v-on:change="changeEditable($event.target.checked, instance, field)" 
													v-model="instance[field.db_title]" style="display: none;"
												/>
												<div class="checkbox-rectangle">
													<img class="checkbox-mark" src="/vendor/fastadminpanel/images/checkbox-mark.svg" alt="">
												</div>
											</label>
											<span v-else v-text="instance[field.db_title]"></span>
										</div>
									</td>
									<td class="td-actions">
										<div class="td-content-conteiner td-actions-container">
											<router-link :to="{name: 'crudsEntity', params: {table: table, id: instance.id}}" class="btn btn-small btn-blue btn-with-tip">
												<img class="btn-svg" src="/vendor/fastadminpanel/images/edit-ico.svg" alt="">
												<div class="btn-tooltip">{{ __('fastadminpanel.edit') }}</div>
											</router-link>
											<div v-if="rolesStore.can(table, 'admin_edit')" class="btn btn-small btn-blue td-actions-delete btn-with-tip" v-on:click="copy(instance.id)" >
												<img class="btn-svg" src="/vendor/fastadminpanel/images/copy-ico.svg" alt="">
												<div class="btn-tooltip">{{ __('fastadminpanel.copy') }}</div>
											</div>
											<div v-if="rolesStore.can(table, 'admin_edit')" class="btn btn-small btn-danger td-actions-delete btn-with-tip" v-on:click="remove(instance.id)">
												<img class="btn-svg" src="/vendor/fastadminpanel/images/close.svg" alt="">
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
							<div class="index-pagination-number index-pagination-prev" :class="{'disabled': currPage == 1}" v-on:click="prevPage()">
								<img class="index-pagination-svg" src="/vendor/fastadminpanel/images/arrow-left-ico.svg" alt="">
							</div>
							<div class="index-pagination-numbers">
								<template v-for="i in pagesCount">
									<div v-if="pagesCount < 5 || (i == 1 || i == pagesCount || i == currPage)"
										class="index-pagination-number"
										:class="{ 'active': i == currPage }"
										v-on:click="currPage = i" v-text="i">
									</div>
									<div v-else-if="i == currPage - 1 || i == currPage + 1"
										class="index-pagination-number">...</div>
								</template>
							</div>
							<div class="index-pagination-number index-pagination-next" :class="{'disabled': currPage == pagesCount}" v-on:click="nextPage()">
								<img class="index-pagination-svg" src="/vendor/fastadminpanel/images/arrow-right-ico.svg" alt="">
							</div>
						</div>
						<div class="index-pagination-show">
							{{ __('fastadminpanel.showing') }} 
							<span v-text="(offset + 1)"></span> 
							{{ __('fastadminpanel.to') }} 
							<span v-text="(offset + instances.length)"></span> 
							<span v-if="count > 0">
								{{ __('fastadminpanel.of') }} 
								<span v-text="count"></span> 
								{{ __('fastadminpanel.entries') }}
							</span>
						</div>
					</div>
				</div>
				<div v-if="rolesStore.can(table, 'admin_edit')" class="mass-delete-col">
					<button class="btn btn-danger" v-on:click="removeChecked">
						{{ __('fastadminpanel.delete_checked') }}
					</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
const crudsEntitiesPage = {
	template: '#crud-entities',
	props: [],
	data() {
		return {
			perPage: 10,
			order: '',
			sort: 'DESC',
			count: 0,
			offset: 0,
			instances: [],
			searchTimeout: 0,
			search: '',
		}
	},
	computed: {
		...Pinia.mapStores(useCrudsStore, useRolesStore),
		table() {
			return this.$route.params.table
		},
		fields() {
			return this.crudsStore.getFields(this.table)
		},
		title() {
			return this.crudsStore.getTitle(this.table)
		},
		pagesCount() {
			return Math.ceil(this.count / this.perPage)
		},
		currPage: {
			get() {
				return parseInt(this.offset / this.perPage) + 1
			},
			set(newValue) {
				this.offset = (newValue - 1) * this.perPage
				this.fetchFieldInstances()
			},
		},
	},
	watch: {
		'$route.params.table'() {
			this.order = this.getDefaultOrder()
			this.fetchFieldInstances()
		},
		perPage() {
			this.fetchFieldInstances()
		},
		sort() {
			this.fetchFieldInstances()
		},
		search(val) {

			clearTimeout(this.searchTimeout)

			this.searchTimeout = setTimeout(()=>{
				this.currPage = 1
			}, 500)
		},
	},
	created() {
	},
	mounted() {
		this.order = this.getDefaultOrder()
		this.fetchFieldInstances()
	},
	methods: {
		getDefaultOrder() {

			const defaultOrder = this.crudsStore.getDefaultOrder(this.table)

			if (defaultOrder) {

				const defaultField = this.fields.find(f => f.show_in_list != 'no' && f.db_title == defaultOrder)
	
				if (defaultField) return defaultField.db_title
			}

			return 'id'
			// return this.fields.find(f => f.show_in_list != 'no').db_title ?? 'id'
		},
		prevPage() {
			if (this.currPage != 1 && this.pagesCount > 1)
				this.currPage--
		},
		nextPage() {
			if (this.currPage != this.pagesCount && this.pagesCount > 1)
				this.currPage++
		},
		async fetchFieldInstances() {

			const route = "{{ route('admin-api-cruds-entities-index', ['table' => 'table'], false) }}".replace('table', this.table)

			const response = await req.get(route, {
				search: this.search,
				per_page: this.perPage,
				order: this.order,
				sort_order: this.sort,
				offset: this.offset,
			})

			this.instances = response.data.instances
			this.count = response.data.count
		},
		async copy(id) {

			const route = "{{ route('admin-api-cruds-entities-copy', ['table' => 'table', 'entity_id' => 'entity_id'], false) }}"
				.replace('table', this.table)
				.replace('entity_id', id)

			await req.post(route)

			this.fetchFieldInstances()
		},
		async changeEditable(value, instance, field) {

			switch (field.type) {
				case 'number':
					value = parseInt(value)
					break;
				case 'checkbox':
					value = value ? 1 : 0
					break;
			}

			const route = "{{ route('admin-api-cruds-entities-fields-update', ['table' => 'table', 'entity_id' => 'entity_id', 'field_id' => 'field_id'], false) }}"
				.replace('table', this.table)
				.replace('entity_id', instance.id)
				.replace('field_id', field.id)

			await req.put(route, {
				value: value
			})
		},
		async remove(id) {

			if (!confirm("Are you sure?")) {
				return
			}

			const route = "{{ route('admin-api-cruds-entities-destroy', ['table' => 'table', 'entity_id' => 'entity_id'], false) }}"
				.replace('table', this.table)
				.replace('entity_id', id)

			const response = await req.delete(route)
			if (response.success) this.fetchFieldInstances()
			else alert('Error')
		},
		async removeChecked() {

			if (!confirm("Are you sure?")) {
				return
			}

			const ids = this.instances.filter(i => i.is_marked).map(i => i.id)

			const route = "{{ route('admin-api-cruds-entities-bulk-destroy', ['table' => 'table'], false) }}"
				.replace('table', this.table)

			const response = await req.delete(route, {
				ids: ids,
			})

			if (response.success) this.fetchFieldInstances()
			else alert('Error')
		},
		setMarked(isMark) {

			this.instances.forEach((elm) => {
				elm.is_marked = isMark
			})
		},
	},
}
</script>
