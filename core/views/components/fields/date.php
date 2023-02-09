<script type="text/x-template" id="template-field-date">
	<div class="form-group">
		
		<div class="field-title">
			<label class="edit-field-title control-label" v-text="field.title"></label>
			
			<div class="field-remark" v-if="field.remark">
				i
				<div class="field-remark-modal" v-text="field.remark"></div>
			</div>
		</div>

		<div class="edit-field-inner">
			<input class="form-control datepicker" data-init="0" type="text" :id="id" v-on:change="error = ''">
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-date', {
		template: '#template-field-date',
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
					this.value = '2000-01-01'
				return true
			},
		},
		computed: {
			id() {

				if (this.field.db_title) {

					return this.field.db_title
				}

				if (this.pointer) {

					return 'date-' + this.field.id + '-' + this.pointer.join('-')
				}

				return 'date-' + this.field.id
			},
			default() {
				return '2000-01-01'
			},
		},
		mounted() {

			const app = this
			const today = new Date()
			let date = today.getFullYear().toString().padStart(2, '0') + '-' + 
				(today.getMonth() + 1).toString().padStart(2, '0') + '-' + 
				today.getDate().toString().padStart(2, '0')

			if (this.value)
				date = this.value
			else this.value = date

			if ($('#' + this.id).attr('data-init') == "0") {

				$('#' + this.id).datepicker({
					dateFormat: "yy-mm-dd",
					onSelect(text) {
						app.value = text
					}
				})
				$('#' + this.id).attr('data-init', '1')
			}

			$('#' + this.id).datepicker( "setDate", date )
		},
	})
</script>