<script type="text/x-template" id="template-field-datetime">
	<div class="form-group">
		
		<div class="field-title">
			<label class="edit-field-title control-label" v-text="field.title"></label>
			
			<div class="field-remark" v-if="field.remark">
				i
				<div class="field-remark-modal" v-text="field.remark"></div>
			</div>
		</div>

		<div class="edit-field-inner">
			<input class="form-control datetimepicker" data-init="0" type="text" :id="id" v-on:change="error = ''">
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-datetime',{
		template: '#template-field-datetime',
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

				if (!this.value)
					this.value = '2000-01-01 12:00:00'
				return true
			},
		},
		computed: {
			id() {

				if (this.field.db_title) {

					return this.field.db_title
				}

				if (this.pointer) {

					return 'datetime-' + this.field.id + '-' + this.pointer.join('-')
				}

				return 'datetime-' + this.field.id
			},
			default() {
				return '2000-01-01 12:00:00'
			},
		},
		mounted() {

			const app = this
			const today = new Date()
			let date = today.getFullYear() + '-' +
				(today.getMonth()+1).toString().padStart(2, '0') + '-' + 
				today.getDate().toString().padStart(2, '0') + ' ' + 
				today.getHours().toString().padStart(2, '0') + ':' + 
				today.getMinutes().toString().padStart(2, '0')

			if (this.value)
				date = this.value
			else this.value = date

			if ($('#' + this.id).attr('data-init') == "0") {

				$('#' + this.id).datetimepicker({
					format: "Y-m-d H:i",
					onChangeDateTime(d) {
						const save_date = new Date(d.getTime() - d.getTimezoneOffset() * 60 * 1000);
						app.value = save_date.getUTCFullYear() + '-' +
							('00' + (save_date.getUTCMonth()+1)).slice(-2) + '-' +
							('00' + save_date.getUTCDate()).slice(-2) + ' ' + 
							('00' + save_date.getUTCHours()).slice(-2) + ':' + 
							('00' + save_date.getUTCMinutes()).slice(-2) + ':' + 
							('00' + save_date.getUTCSeconds()).slice(-2)
					}
				})
				$('#' + this.id).attr('data-init', '1')
			}
			
			$('#' + this.id).val( date )
		},
	})
</script>