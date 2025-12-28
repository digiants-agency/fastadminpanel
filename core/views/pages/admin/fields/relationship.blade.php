<template id="field-relationship">
	<div>
		<div v-if="field.relationship_count == 'editable'">
			<div class="editable-blocks">
				<h1 v-text="field.title"></h1>
				<div v-for="(group, i) in field.value" class="mb-15 relationship_block">
					<div
						class="reletionship_title" 
						v-on:click="e => e.target.parentElement.classList.toggle('active')"
						v-text="getEditableTitle(group.fields[0])" 
					></div>
					<div class="btn btn-editable-delete btn-delete btn-danger btn-small" v-on:click="field.value.splice(i, 1)">
						<img src="/vendor/fastadminpanel/images/close.svg" alt="">
					</div>
					<div class="reletionship_inner">
						<div v-for="(f, index) in group.fields.filter(f => f.is_visible && table !== f.relationship_table_name)" :class="'field-' + f.type">
							<component
								:is="findFieldComponent(f.type, field.relationship_table_name, f.db_title ?? (f.relationship_table_name + '_' + f.relationship_count))"
								:field="f"
								:table="field.relationship_table_name"
								:parent_id="i"
								ref="refield"
							></component>
						</div>
					</div>
				</div>
			</div>
			<div class="btn btn-add" v-on:click="addGroup">
				{{ __('fastadminpanel.add_field') }} +
			</div>
		</div>
		<div v-else class="form-group">
			<div class="field-title">
				<label class="edit-field-title" v-text="field.title"></label>
			</div>
			<div>
				<div class="select-wrapper" v-if="field.relationship_count == 'single'">
					<v-select
						class="form-control"
						:options="options"
						label="title"
						:reduce="value => value.id"
						:filterable="filterable"
						v-on:search="onSearch"
						v-model="field.value"
					></v-select>
					<div class="select-arrow-block">
						<img src="/vendor/fastadminpanel/images/dropdown-ico.svg" alt="" class="select-arrow">
					</div>
				</div>
				<div v-else-if="field.relationship_count == 'many'">
					<div class="relationship-many" >
						<div class="select-wrapper">
							<v-select
								class="form-control"
								:options="options"
								label="title"
								:reduce="value => value.id"
								:filterable="filterable"
								multiple
								v-on:search="onSearch"
								v-model="field.value"
							></v-select>
						</div>
					</div>
				</div>
				<div class="input-error" v-text="error"></div>
			</div>
		</div>
	</div>
</template>

{{-- TODO: divide - single, many, editable --}}
<script>
app.component('field-relationship', {
	template: '#field-relationship',
	mixins: [recursiveFieldMixin, findFieldComponentMixin],
	props: ['field', 'pointer', 'table'],
	data() {
		return {
			ajaxThreshold: {{config('fap.relationship_ajax_threshold')}},
			error: '',
			searchTimeout: 0,
			options: [],
		}
	},
	computed: {
		filterable() {
			return this.field.values.length < this.ajaxThreshold
		},
	},
	watch: {
	},
	created() {
		this.options = this.field.relationship_count == 'single' 
			? [
				{id: 0, title: '{{ __('fastadminpanel.choose_select') }}'},
				...this.field.values,
			]
			: [...this.field.values]
	},
	mounted() {
	},
	methods: {
		async onSearch(search, loading) {

			if (this.filterable || !search.length) return

			clearTimeout(this.searchTimeout)
			this.searchTimeout = setTimeout(async () => {

				const route = "{{ route('admin-api-cruds-entities-index', ['table' => 'table'], false) }}"
					.replace('table', this.field.relationship_table_name)

				const response = await req.get(route, {
					fields: [`${this.field.relationship_view_field} as title`],
					order: this.field.relationship_view_field,
					order_sort: 'ASC',
					search: search,
					per_page: 200,
				})

				if (response.success) {
					const options = response.data.instances.map(i => ({
						id: i.id,
						title: i.title,
					}))

					const applyOptions = []
					const fields = this.field.relationship_count == 'single'
						? [
							{id: 0, title: '{{ __('fastadminpanel.choose_select') }}'},
							this.field.values.find(f => f.id == this.field.value),
						]
						: this.field.value.map(id => this.field.values.find(f => f.id == id))

					for (const field of fields) {
						if (!field) continue
						const option = options.find(o => o.id == field.id)
						if (!option) {
							applyOptions.push(field)
						}
					}

					this.options = [
						...applyOptions,
						...options,
					]
				}
			}, 500)
		},
		getEditableTitle(field) {

			if (field.relationship_count == 'single') {

				const option = field.values.find(v => v.id == field.value)

				if (!option) {
					return '{{ __('fastadminpanel.choose_select') }}'
				}

				return option.title
			}

			return field.value
		},
		check() {
			return true
		},
		addGroup() {
			this.field.value.push({
				id: 0, 
				fields: JSON.parse(JSON.stringify(this.field.values)), 
			})
		},
	},
})
</script>