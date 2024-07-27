<template id="crud-edit">
	<div class="table-edit">
		<h1>{{ __('fastadminpanel.gen_desc') }}</h1>
		<div class="menu-table">
			<div class="form-group">
				<label class="menu-item-title">{{ __('fastadminpanel.gen_item') }}</label>
				<div class="menu-item-input">
					<div class="select-wrapper">
						<select v-on:change="setCrud" class="form-control">
							<option :value="''">{{ __('fastadminpanel.new') }}</option>
							<option :value="crud.table_name" v-for="crud in crudsStore.cruds.sort((a,b) => (a.title > b.title) ? 1 : ((b.title > a.title) ? -1 : 0))" v-text="crud.title"></option>
						</select>
						<div class="select-arrow-block">
							<img src="/vendor/fastadminpanel/images/dropdown-ico.svg" alt="" class="select-arrow">
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="menu-item-title">{{ __('fastadminpanel.crud_name') }}</label>
				<div class="menu-item-input">
					<input v-model="crudItem.table_name" class="form-control" placeholder="ex. books or products (used to generate DB table)" type="text" :disabled="!isNew">
				</div>
			</div>
			<div class="form-group">
				<label class="menu-item-title">{{ __('fastadminpanel.crud_title') }}</label>
				<div class="menu-item-input">
					<input v-model="crudItem.title" class="form-control" placeholder="Menu title (used for menu item)" type="text">
				</div>
			</div>
			<div class="form-group disabled">
				<label class="menu-item-title">{{ __('fastadminpanel.soft_delete') }}</label>
				<div class="menu-item-input">
					<div class="select-wrapper">
						<select v-model="crudItem.is_soft_delete" class="form-control">
							<option :value="0">{{ __('fastadminpanel.no') }}</option>
							<option :value="1">{{ __('fastadminpanel.yes') }}</option>
						</select>
						<div class="select-arrow-block">
							<img src="/vendor/fastadminpanel/images/dropdown-ico.svg" alt="" class="select-arrow">
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="menu-item-title">{{ __('fastadminpanel.is_dev') }}</label>
				<div class="menu-item-input">
					<div class="select-wrapper">
						<select v-model="crudItem.is_dev" class="form-control">
							<option :value="0">{{ __('fastadminpanel.no') }}</option>
							<option :value="1">{{ __('fastadminpanel.yes') }}</option>
						</select>
						<div class="select-arrow-block">
							<img src="/vendor/fastadminpanel/images/dropdown-ico.svg" alt="" class="select-arrow">
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="menu-item-title">{{ __('fastadminpanel.multilang') }}</label>
				<div class="menu-item-input">
					<div class="select-wrapper">
						<select v-model="crudItem.multilanguage" class="form-control" :disabled="!isNew">
							<option :value="0">{{ __('fastadminpanel.no') }}</option>
							<option :value="1">{{ __('fastadminpanel.yes') }}</option>
						</select>
						<div class="select-arrow-block">
							<img src="/vendor/fastadminpanel/images/dropdown-ico.svg" alt="" class="select-arrow">
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="menu-item-title">Is docs?</label>
				<div class="menu-item-input">
					<div class="select-wrapper">
						<select v-model="crudItem.is_docs" class="form-control">
							<option :value="0">{{ __('fastadminpanel.no') }}</option>
							<option :value="1">{{ __('fastadminpanel.yes') }}</option>
						</select>
						<div class="select-arrow-block">
							<img src="/vendor/fastadminpanel/images/dropdown-ico.svg" alt="" class="select-arrow">
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="menu-item-title">Show statistics (Dashboard)?</label>
				<div class="menu-item-input">
					<div class="select-wrapper">
						<select v-model="crudItem.is_statistics" class="form-control">
							<option :value="0">{{ __('fastadminpanel.no') }}</option>
							<option :value="1">{{ __('fastadminpanel.yes') }}</option>
						</select>
						<div class="select-arrow-block">
							<img src="/vendor/fastadminpanel/images/dropdown-ico.svg" alt="" class="select-arrow">
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="menu-item-title">Model</label>
				<div class="edit-field-inner">
					<input class="form-control" type="text" v-model="crudItem.model">
				</div>
			</div>
			<div class="form-group">
				<label class="menu-item-title">Default order in list (db_title)</label>
				<div class="edit-field-inner">
					<input class="form-control" type="text" v-model="crudItem.default_order">
				</div>
			</div>
			<div class="form-group">
				<label class="menu-item-title">Sort</label>
				<div class="menu-item-input">
					<input v-model="crudItem.sort" class="form-control" placeholder="0" type="text">
				</div>
			</div>
			<div class="form-group">
				<label class="menu-item-title">Dropdown</label>
				<div class="menu-item-input">
					<div class="select-wrapper">
						<select v-model="crudItem.dropdown_slug" class="form-control">
							<option :value="''">None</option>
							<option :value="dropdown.slug" v-for="dropdown in dropdownsStore.dropdowns" v-text="dropdown.title"></option>
						</select>
						<div class="select-arrow-block">
							<img src="/vendor/fastadminpanel/images/dropdown-ico.svg" alt="" class="select-arrow">
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="menu-item-title">Icon</label>
				<div class="edit-field-inner">
					<input class="form-control" type="text" v-model="crudItem.icon">
					<div class="photo-preview-wrapper">
						<img :src="crudItem.icon" alt="" class="photo-preview-img">
						<div class="btn btn-primary" v-on:click="changePhoto(crudItem)">Add</div>
					</div>
				</div>
			</div>
		</div>
		<h1>Edit fields</h1>
		<div class="menu-table-editfields">
			<table class="table">
				<tr>
					<td class="table-header-title">Is visible?</td>
					<td class="table-header-title">Lang</td>
					<td class="table-header-title">Show in list</td>
					<td class="table-header-title">Field type</td>
					<td class="table-header-title">Field DB name</td>
					<td class="table-header-title">Field visual name</td>
					<td class="table-header-title">Remark</td>
					<td class="table-header-title"></td>
					<td class="table-header-title"></td>
				</tr>
				<tr v-for="(field, index) in crudItem.fields">
					<td class="menu-table-field">
						<div class="menu-table-field-td-wrapper">
							<label class="checkbox">
								<input class="checkbox-input" style="display: none;" type="checkbox" v-model="field.is_visible">
								<div class="checkbox-rectangle">
									<img src="/vendor/fastadminpanel/images/checkbox-mark.svg" alt="" class="checkbox-mark">
								</div>
							</label>
						</div>
					</td>
					<td class="menu-table-field">
						<div class="menu-table-field-td-wrapper">
							<div class="select-wrapper">
								<select v-model="field.lang" class="form-control type">
									<option :value="1">Separate</option>
									<option :value="0">Common</option>
								</select>
								<div class="select-arrow-block">
									<img src="/vendor/fastadminpanel/images/dropdown-ico.svg" alt="" class="select-arrow">
								</div>
							</div>
						</div>
					</td>
					<td class="menu-table-field">
						<div class="menu-table-field-td-wrapper">
							<div class="select-wrapper">
								<select v-model="field.show_in_list" class="form-control type">
									<option value="no">No</option>
									<option value="yes">Yes</option>
									<option value="editable">Editable</option>
								</select>
								<div class="select-arrow-block">
									<img src="/vendor/fastadminpanel/images/dropdown-ico.svg" alt="" class="select-arrow">
								</div>
							</div>
						</div>
					</td>
					<td class="menu-table-field">
						<div class="menu-table-field-td-wrapper">
							<div class="select-wrapper">
								<select v-model="field.type" v-on:change="resetField(field, index)" class="form-control type" :disabled="field.id != 0">
									<option value="text">Text</option>
									<option value="textarea">Long text</option>
									<option value="ckeditor">Ckeditor</option>
									<option value="checkbox">Checkbox</option>
									<option value="color">Color picker</option>
									<option value="date">Date picker</option>
									<option value="datetime">Date and time picker</option>
									<option value="relationship">Relationship</option>
									<option value="file">File</option>
									<option value="photo">Photo</option>
									<option value="gallery">Gallery</option>
									<option value="password">Password (hashed)</option>
									<option value="money">Money</option>
									<option value="number">Number</option>
									<option value="enum">Select (ENUM)</option>
								</select>
								<div class="select-arrow-block">
									<img src="/vendor/fastadminpanel/images/dropdown-ico.svg" alt="" class="select-arrow">
								</div>
							</div>
						</div>
					</td>
					<td class="menu-table-field">
						<div class="menu-table-field-td-wrapper">
							<input v-if="field.type != 'relationship' && field.type != 'enum'" v-model="field.db_title" type="text" class="form-control title" placeholder="Field DB name" :disabled="field.id != 0">
							<div v-else-if="field.type == 'relationship'" class="w-100">
								<div class="select-wrapper">
									<select v-model="field.relationship_count" class="form-control type" title="One to many require Single relation on other table" :disabled="field.id != 0">
										<option value="single">Single</option>
										<option value="many">Many</option>
										<option value="editable">One to many</option>
									</select>
									<div class="select-arrow-block">
										<img src="/vendor/fastadminpanel/images/dropdown-ico.svg" alt="" class="select-arrow">
									</div>
								</div>
								<div class="select-wrapper">
									<select v-model="field.relationship_table_name" class="form-control type" :disabled="field.id != 0">
										<option :value="item.table_name" v-for="item in crudsStore.cruds" v-text="item.title"></option>
									</select>
									<div class="select-arrow-block">
										<img src="/vendor/fastadminpanel/images/dropdown-ico.svg" alt="" class="select-arrow">
									</div>
								</div>
								<div v-if="field.relationship_table_name && field.relationship_count != 'editable'">
									<div class="select-wrapper">
										<select v-model="field.relationship_view_field" class="form-control type">
											<option :value="item.db_title" v-for="item in crudsStore.getFields(field.relationship_table_name)" v-text="item.title"></option>
										</select>
										<div class="select-arrow-block">
											<img src="/vendor/fastadminpanel/images/dropdown-ico.svg" alt="" class="select-arrow">
										</div>
									</div>
								</div>
							</div>
							<div v-else-if="field.type == 'enum'">
								<input v-model="field.db_title" type="text" class="form-control title" placeholder="Field DB name" :disabled="field.id != 0">
								<input v-for="(item, index) in field.enum" v-model="field.enum[index]" type="text" class="form-control title" placeholder="Element">
								<button class="btn-primary btn" v-on:click="field.enum.push('')">Add</button>
								<button class="btn-danger btn" v-on:click="field.enum.splice(-1,1)">Remove</button>
							</div>
						</div>
					</td>
					<td class="menu-table-field">
						<div class="menu-table-field-td-wrapper">
							<input v-model="field.title" type="text" class="form-control title" placeholder="Title">
						</div>
					</td>
					<td class="menu-table-field">
						<div class="menu-table-field-td-wrapper">
							<input v-model="field.remark" type="text" class="form-control title" placeholder="Optional detailed info">
						</div>
					</td>
					<td class="menu-table-field">
						<div class="menu-table-field-td-wrapper">
							<div class="select-wrapper">
								<select v-model="field.required" class="form-control type">
									<option value="optional">Optional</option>
									<option value="required">Required</option>
									<option value="required_unique">Required unique</option>
								</select>
								<div class="select-arrow-block">
									<img src="/vendor/fastadminpanel/images/dropdown-ico.svg" alt="" class="select-arrow">
								</div>
							</div>
						</div>
					</td>
					<td class="menu-table-field">
						<div class="menu-table-field-td-wrapper">
							<div class="menu-table-flex-btns">
								<div v-on:click="moveItemUp(index)" class="btn btn-blue btn-small">
									<img src="/vendor/fastadminpanel/images/up.svg" alt="" class="btn-svg">
								</div>
								<div v-on:click="crudItem.fields.splice(index, 1)" class="rem btn btn-danger btn-small">
									<img src="/vendor/fastadminpanel/images/close.svg" alt="" class="btn-svg">
								</div>
							</div>
						</div>
					</td>
				</tr>
			</table>
			<button v-on:click="addField(crudItem)" type="button" class="btn btn-add"><span class="btn-plus">+</span> Add one more field</button>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<button v-if="isNew" v-on:click="createCrud()" class="btn btn-primary">Create CRUD</button>
				<div v-else class="sides">
					<button v-on:click="updateCrud()" class="btn btn-primary">Update CRUD</button>
					<button v-on:click="removeCrud()" class="btn btn-danger">Remove CRUD</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
const crudsEditPage = {
	template: '#crud-edit',
	mixins: [addFileMixin],
	props: [],
	data() {
		return {
			crudItem: this.getEmptyCrud(),
			isNew: true,
			maxId: 1,
		}
	},
	computed: {
		...Pinia.mapStores(useCrudsStore, useDropdownsStore),
	},
	watch: {
	},
	created() {
	},
	mounted() {
	},
	methods: {
		getEmptyCrud() {
			return {
				table_name: '',
				title: '',
				is_soft_delete: 0,
				is_dev: 0,
				multilanguage: 1,
				sort: 10,
				fields: [],
				dropdown_slug: '',
				icon: '',
				is_docs: 1,
				is_statistics: 0,
				model: '',
				default_order: '',
			}
		},
		getEmptyField(id = 0, type = 'text') {
			return {
				id: id,
				required: 'optional',
				is_visible: true,
				lang: 1,
				show_in_list: 'no',
				db_title: '',
				title: '',
				type: type,
			}
		},
		setCrud(e) {

			const tableName = e.target.value
			const crud = this.crudsStore.cruds.find(c => c.table_name == tableName)

			if (crud) {
				this.crudItem = crud
				this.isNew = false
			} else {
				this.crudItem = this.getEmptyCrud()
				this.isNew = true
			}

			this.maxId = Math.max(...this.crudItem.fields.map(o => o.id), 0) + 1
		},
		changePhoto(crudItem) {

			this.addFile((photo) => crudItem.icon = photo, 'admin')
		},
		addField(crudItem) {

			const field = this.getEmptyField()

			crudItem.fields.push(field)
		},
		moveItemUp(index) {

			if (index > 0) {
				const temp = this.crudItem.fields[index]
				this.crudItem.fields[index] = this.crudItem.fields[index - 1]
				this.crudItem.fields[index - 1] = temp
			}
		},
		resetField(field, index) {

			this.crudItem.fields[index] = this.getEmptyField(field.id, field.type)
		},
		setFieldIds() {

			this.crudItem.fields.forEach(field => {
				if (!field.id) {
					field.id = this.maxId++
				}
			})
		},
		clearFeildIds() {

			this.crudItem.fields.forEach(field => {
				field.id = 0
			})
			this.maxId = 1;
		},
		async createCrud() {

			this.setFieldIds()

			const response = await req.post('{{ route("admin-api-cruds-store", [], false) }}', this.crudItem)

			if (response.success) {
				
				this.crudItem.model = response.data.model
				this.crudsStore.addCrud(this.crudItem)
				this.isNew = false
				alert('Successfully created')

			} else {

				alert(response.data.message)
				this.clearFeildIds()
			}
		},
		async updateCrud() {

			this.setFieldIds()

			const response = await req.put('{{ route("admin-api-cruds-update", ["table" => "0"], false) }}'
				.replace('0', this.crudItem.table_name), this.crudItem)

			if (response.success) {
				
				alert('Successfully updated')

			} else {

				alert(response.data.message)
				// this.clearFeildIds() // clear unsaved ones
			}
		},
		async removeCrud() {

			const response = await req.delete('{{ route("admin-api-cruds-destroy", ["table" => "0"], false) }}'
				.replace('0', this.crudItem.table_name), this.crudItem)

			if (response.success) {

				this.crudsStore.removeCrud(this.crudItem.table_name)
				this.setCrud({target: {value: ''}})
				alert('Successfully deleted')

			} else {

				alert(response.data.message)
			}
		},
	},
}
</script>