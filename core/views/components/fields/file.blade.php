<script type="text/x-template" id="template-field-file">
	<div class="form-group">
		
		<div class="field-title">
			<label class="edit-field-title control-label" v-text="field.title"></label>
			
			<div class="field-remark" v-if="field.remark">
				i
				<div class="field-remark-modal" v-text="field.remark"></div>
			</div>
		</div>

		<div class="edit-field-inner">
			<input class="form-control" type="text" :id="field.db_title" v-model="value" v-on:change="error = ''">
			<div class="btn btn-primary add-file-btn" v-on:click="add_file(field.db_title)">{{ __('fastadminpanel.add_field') }}</div>
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-file',{
		template: '#template-field-file',
		props: ['field', 'pointer'],
		mixins: [recursiveFieldMixin],
		components: {},
		data() {
			return {
				error: '',
			}
		},
		methods: {
			check() {

				if (this.field.required != 'optional' && !this.file.value) {
					this.error = '{{ __('fastadminpanel.required_field') }}'
				} else if (this.field.required == 'required_once') {
					// TODO
				}

				if (!this.value)
					this.value = ''

				return true
			},
			add_file(id) {

				window.open('/laravel-filemanager?type=file', 'FileManager', 'width=900,height=600');
				window.SetUrl = (items)=>{

					for (var i = 0; i < items.length; i++) {

						var url = items[i].url.replace(/^.*\/\/[^\/]+/, '')
						this.value = decodeURIComponent(url)

						break;
					}
				};
			},
		},
	})
</script>