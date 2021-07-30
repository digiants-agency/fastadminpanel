<script type="text/x-template" id="template-field-relationship">
	<div>
		<div class="mb-30 ml-50" v-if="field.relationship_count == 'editable'">
			<div class="row">
				<div class="col-sm-10 offset-2">
					<h3 class="relationships_block_title" v-text="field.title"></h3>
				</div>
			</div>
			<div class="mb-15 relationship_block" v-for="(group, i) in field.value" >
				<div class="reletionship_title" v-text="group.fields[0].value" @click="e => e.target.parentElement.classList.toggle('active')"></div>
				<div class="reletionship_inner" >
					<div v-for="(f, index) in group.fields" v-if="f.is_visible" >
						<component <?php /*:name="f.db_table"*/ ?> :is="'template-field-' + f.type" ref="refield" :field="f" v-if="table_name != f.relationship_table_name" :table_name="field.relationship_table_name"></component>
					</div>
					<div class="flex justify-end">
						<div class="btn btn-danger" v-on:click="field.value.splice(i, 1)">Delete</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="offset-sm-2 col-sm-10">
					<div class="btn btn-primary" v-on:click="field.value.push({id: 0, fields: JSON.parse(JSON.stringify(field.values))})">Add</div>
				</div>
			</div>
		</div>
		<div class="row form-group" v-else>
			<label class="col-sm-2 control-label" v-text="field.title"></label>
			<div class="col-sm-10">
				<select v-if="field.relationship_count == 'single'" class="form-control" v-model="field.value">
					<option :value="item.id" v-for="item in field.values" v-text="item.title"></option>
				</select>
				<div v-else-if="field.relationship_count == 'many'">
					<div class="relationship-many" v-for="(elm, index) in field.value">
						<select class="form-control" v-model="field.value[index]">
							<option :value="item.id" v-for="item in field.values" v-text="item.title"></option>
						</select>
						<div class="btn btn-danger" v-on:click="field.value.splice(index, 1)">Delete</div>
					</div>
					<div class="btn btn-primary" v-on:click="field.value.push(field.values[0] ? field.values[0].id : 0)">Add</div>
				</div>
				<div class="input-error" v-text="error"></div>
			</div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-relationship',{
		template: '#template-field-relationship',
		props:['field', 'table_name'],
		components: {},
		data: function () {
			return {
				error: '',
			}
		},
		methods: {
			check: function(){

				return true
			},

		},
	})
</script>