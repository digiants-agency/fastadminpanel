<script type="text/x-template" id="template-field-money">
	<div class="row form-group">
		<label class="col-sm-2 control-label" v-text="field.title"></label>
		<div class="col-sm-10">
			<input class="form-control" type="text" v-model="field.value" v-on:change="error = ''">
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-money',{
		template: '#template-field-money',
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