<script type="text/x-template" id="template-field-relationship">
	<div>

		<div v-if="field.relationship_count == 'editable'">
			<div class="editable-blocks">
				<div class="mb-15 relationship_block" v-for="(group, i) in field.value" :class="{active: table_name == 'orders'}">
					
					<div class="reletionship_title" 
						v-text="group.fields[0].relationship_count != 'single' ? group.fields[0].value : group.fields[0].value_title" 
						v-if="table_name != 'orders'" 
						@click="e => e.target.parentElement.classList.toggle('active')"
					></div>

					<div class="btn btn-editable-delete btn-delete btn-danger btn-small" v-on:click="field.value.splice(i, 1)" v-if="table_name != 'orders'">
						<svg class="btn-svg" width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M4.88111 4.00023L7.8722 1.00901C7.95447 0.926667 7.99987 0.816813 8 0.699675C8 0.582472 7.9546 0.472488 7.8722 0.390277L7.61008 0.128228C7.52767 0.0456915 7.41782 0.000488281 7.30055 0.000488281C7.18348 0.000488281 7.07363 0.0456915 6.99122 0.128228L4.00013 3.11925L1.00891 0.128228C0.926634 0.0456915 0.816715 0.000488281 0.699512 0.000488281C0.582439 0.000488281 0.47252 0.0456915 0.390244 0.128228L0.128 0.390277C-0.0426667 0.560944 -0.0426667 0.838537 0.128 1.00901L3.11915 4.00023L0.128 6.99132C0.0456585 7.07379 0.000325203 7.18364 0.000325203 7.30078C0.000325203 7.41792 0.0456585 7.52777 0.128 7.61018L0.390179 7.87223C0.472455 7.9547 0.582439 7.99997 0.699447 7.99997C0.81665 7.99997 0.926569 7.9547 1.00885 7.87223L4.00006 4.88114L6.99115 7.87223C7.07356 7.9547 7.18341 7.99997 7.30049 7.99997H7.30062C7.41776 7.99997 7.52761 7.9547 7.61002 7.87223L7.87213 7.61018C7.95441 7.52784 7.9998 7.41792 7.9998 7.30078C7.9998 7.18364 7.95441 7.07379 7.87213 6.99138L4.88111 4.00023Z" fill="white"/>
						</svg>
					</div>

					<div class="reletionship_inner" >
						<div v-for="(f, index) in group.fields" v-if="f.is_visible" :class="'field-' + f.type">
							<component <?php /*:name="f.db_table"*/ ?> :is="'template-field-' + f.type" ref="refield" :field="f" v-if="table_name != f.relationship_table_name" :table_name="field.relationship_table_name" :parent_hash="group.hash"></component>
						</div>
					</div>
				</div>
			</div>

			<div class="btn btn-add" v-on:click="add_group" v-if="table_name != 'orders'">{{ __('fastadminpanel.add_field') }} +</div>
		</div>
		
		<div class="form-group" v-else>
			<div class="field-title">
				<label class="edit-field-title" v-text="field.title"></label>
			</div>
			<div>
				<div class="select-wrapper" v-if="field.relationship_count == 'single'">
					<v-select class="form-control" :options="[].concat.apply([{id: 0, title: '{{ __('fastadminpanel.choose_select') }}'}], field.values)" label="title" :reduce="title => title.id" v-model="field.value"></v-select>

					<div class="select-arrow-block">
						<svg class="select-arrow" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
							<clipPath id="clip0_755_2893">
							<rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
							</clipPath>
						</svg>
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
</script>
<script>
	Vue.component('template-field-relationship',{
		template: '#template-field-relationship',
		props: ['field', 'table_name', 'pointer'],
		components: {},
		data() {
			return {
				error: '',
			}
		},
		methods: {
			check() {

				return true
			},
			add_group() {

				this.field.value.push({
					id: 0, 
					fields: JSON.parse(JSON.stringify(this.field.values)), 
					hash: Math.random() * Date.now()
				})
			},
		},
	})
</script>