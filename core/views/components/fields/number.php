<script type="text/x-template" id="template-field-number">
	<div class="form-group">
		
		<div class="field-title">
			<label class="edit-field-title control-label" v-text="field.title"></label>
			
			<div class="field-remark" v-if="field.remark">
				i
				<div class="field-remark-modal" v-text="field.remark"></div>
			</div>
		</div>

		<div class="edit-field-inner">
			<input class="form-control" type="text" v-model="field.value" v-on:change="error = ''">
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-number',{
		template: '#template-field-number',
		props:['field'],
		components: {},
		data: function () {
			return {
				error: '',
			}
		},
		methods: {
			check: function(){

				if (!$.isNumeric(this.field.value))
					this.error = 'Field must be numeric. Use "." instead of ","'

				if (this.error == '')
					return true
				return false
			},
		},
	})
</script>