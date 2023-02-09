<script type="text/x-template" id="template-field-color">
	<div class="form-group">
		<div class="field-title">
			<label class="edit-field-title control-label" v-text="field.title"></label>
			
			<div class="field-remark" v-if="field.remark">
				i
				<div class="field-remark-modal" v-text="field.remark"></div>
			</div>
		</div>

		<div class="edit-field-inner">
			<input class="form-control colorpicker" type="text" :id="field.db_title" v-on:change="error = ''">
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-color',{
		template: '#template-field-color',
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
					this.value = '#000000'

				return true
			},
		},
		computed: {
			default() {
				return '#000000'
			},
		},
		mounted() {
			
			let color = '#000000'

			if (!this.value)
				color = this.value

			$('#' + this.field.db_title).spectrum({
				color: color,
				change(color) {
					this.value = color.toHexString()
				}
			})
		},
	})
</script>