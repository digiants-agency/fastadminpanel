<template id="crud-entity">
	<div class="edit">
		<div class="">
			<router-link :to="{name: 'crudsEntities', params: {table: table}}" class="btn btn-primary align-self-flex-start btn-edit">
				<img src="/vendor/fastadminpanel/images/arrow-back.svg" alt="" />
				{{ __('fastadminpanel.back') }}
			</router-link>
			<div class="space-between">
				<h1 v-if="id == 0">{{ __('fastadminpanel.add_new') }}</h1>
				<h1 v-else>{{ __('fastadminpanel.edit') }}</h1>
			</div>
		</div>
		<div class="edit-fields" :class="table">
			<div v-for="(field, index) in fields.filter(f => f.is_visible && f.relationship_count != 'editable')" :class="'field-' + field.type">
				<component
					:is="findFieldComponent(field.type, table, field.db_title)"
					:field="field"
					:table="table"
					:parent_id="0"
					ref="refield"
				></component>
			</div>
		</div>
		<div v-for="(field, index) in fields.filter(f => f.is_visible && f.relationship_count == 'editable')" :class="'editable-' + table">
			<div class="edit-fields edit-fields-editable">
				<component
					:is="findFieldComponent(field.type, table, field.db_title)"
					:field="field"
					:table="table"
					:parent_id="0"
					ref="refield"
				></component>
			</div>
		</div>
		<div v-if="rolesStore.can(table, 'admin_edit')" class="edit-fields-btns">
			<button v-if="id == 0" class="btn btn-primary" v-on:click="save(true)">{{ __('fastadminpanel.create') }}</button>
			<template v-else>
				<button class="btn btn-primary" v-on:click="save(false)">{{ __('fastadminpanel.save_adj') }}</button>
				<button class="btn btn-primary" v-on:click="save(true)">{{ __('fastadminpanel.save_adj_close') }}</button>
			</template>
		</div>
	</div>
</template>

<script>
const crudsEntityPage = {
	template: '#crud-entity',
	mixins: [findFieldComponentMixin],
	props: [],
	data() {
		return {
			fields: [],
		}
	},
	computed: {
		...Pinia.mapStores(useRolesStore),
		table() {
			return this.$route.params.table
		},
		id() {
			return this.$route.params.id == 'create' ? 0 : this.$route.params.id
		},
	},
	watch: {
		'$route.params.table'() {
			this.fetchEntity()
		},
		'$route.params.id'() {
			this.fetchEntity()
		},
	},
	created() {
		this.fetchEntity()
	},
	mounted() {
	},
	methods: {
		async fetchEntity() {

			const route = "{{ route('admin-api-cruds-entities-show', ['table' => 'table', 'entity_id' => 'entity_id'], false) }}"
				.replace('table', this.$route.params.table)
				.replace('entity_id', this.id)
			
			const response = await req.get(route)

			if (!response.success) {
				alert('Error')
				return
			}

			this.fields = response.data.entity
		},
		async save(isClose) {

			const isFieldsCorrect = !this.$refs.refield.filter(f => !f.check()).length

			if (isFieldsCorrect) {

				const route = "{{ route('admin-api-cruds-entities-insert-or-update', ['table' => 'table', 'entity_id' => 'entity_id'], false) }}"
					.replace('table', this.$route.params.table)
					.replace('entity_id', this.id)

				const response = await req.put(route, {
					table: this.table,
					fields: this.filterFields(this.fields),
					id: this.id,
				})

				if (!response.success) {

					alert('Error')
					return
				}

				if (isClose) {

					this.$router.push({name: 'crudsEntities', params: {table: this.table}})
				}
			}
		},
		filterFields(fields) {

			const filteredFields = []
			
			for (let field of fields) {

				if (field.type == "relationship") {

					if (field.relationship_count != "editable") {

						filteredFields.push({
							type: field.type,
							lang: field.lang,
							db_title: field.db_title,
							value: field.value,
							relationship_count: field.relationship_count,
							relationship_table_name: field.relationship_table_name,
						})

					} else {

						const fieldsEditable = []

						for (let values of field.value) {

							fieldsEditable.push({
								fields: this.filterFields(values.fields), 
								id: values.id
							})
						}
	
						filteredFields.push({
							type: field.type,
							lang: field.lang,
							db_title: field.db_title,
							value: fieldsEditable,
							relationship_count: field.relationship_count,
							relationship_table_name: field.relationship_table_name,
						})
					}

				} else {

					filteredFields.push({
						type: field.type,
						lang: field.lang,
						db_title: field.db_title,
						value: field.value,
					})
				}	
			}

			return filteredFields
		},

	},
}
</script>