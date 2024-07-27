<template id="field-relationship-orders-all">
	<div>
		<div v-if="field.relationship_count == 'editable'">
			<div class="editable-blocks">
				<div v-for="(group, i) in field.value" class="mb-15 relationship_block active">
					<div class="reletionship_inner">
						<div v-for="(f, index) in group.fields.filter(f => f.is_visible && table !== f.relationship_table_name)" :class="'field-' + f.type">
							<component
								:is="findFieldComponent(f.type, field.relationship_table_name, f.db_title)"
								:field="f"
								:table="field.relationship_table_name"
								:parent_id="i"
								ref="refield"
							></component>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div v-else class="form-group">
			<div class="field-title">
				<label class="edit-field-title" v-text="field.title"></label>
			</div>
			<div>
				<div v-if="field.relationship_count == 'single'" class="select-wrapper">
					<v-select class="form-control" :options="[].concat.apply([{id: 0, title: '{{ __('fastadminpanel.choose_select') }}'}], field.values)" label="title" :reduce="title => title.id" v-model="field.value"></v-select>
					<div class="select-arrow-block">
						<img src="/vendor/fastadminpanel/images/dropdown-ico.svg" alt="" class="select-arrow">
					</div>
				</div>
				<div v-else-if="field.relationship_count == 'many'">
					<div class="relationship-many" >
						<div class="select-wrapper">
							<v-select class="form-control" multiple :options="field.values" label="title" :reduce="title => title.id" v-model="field.value"></v-select>
						</div>
					</div>
				</div>
				<div class="input-error" v-text="error"></div>
			</div>
		</div>
	</div>
</template>

<script>
app.component('field-relationship-orders-all', {
	template: '#field-relationship-orders-all',
	mixins: [recursiveFieldMixin, findFieldComponentMixin],
	props: ['field', 'pointer', 'table'],
	data() {
		return {
			error: '',
		}
	},
	computed: {
	},
	watch: {
	},
	created() {
	},
	mounted() {
	},
	methods: {
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