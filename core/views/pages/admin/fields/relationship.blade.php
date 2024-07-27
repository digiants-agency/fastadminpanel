<template id="field-relationship">
	<div>
		<div v-if="field.relationship_count == 'editable'">
			<div class="editable-blocks">
				<div v-for="(group, i) in field.value" class="mb-15 relationship_block">
					<div
						class="reletionship_title" 
						v-on:click="e => e.target.parentElement.classList.toggle('active')"
						v-text="group.fields[0].relationship_count != 'single' ? group.fields[0].value : group.fields[0].value_title" 
					></div>
					<div class="btn btn-editable-delete btn-delete btn-danger btn-small" v-on:click="field.value.splice(i, 1)">
						<img src="/vendor/fastadminpanel/images/close.svg" alt="">
					</div>
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
			<div class="btn btn-add" v-on:click="addGroup">
				{{ __('fastadminpanel.add_field') }} +
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
app.component('field-relationship', {
	template: '#field-relationship',
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