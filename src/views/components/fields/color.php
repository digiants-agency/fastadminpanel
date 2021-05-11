<script type="text/x-template" id="template-field-color">
	<div class="row form-group">
		<label class="col-sm-2 control-label" v-text="field.title"></label>
		<div class="col-sm-10">
			<input class="form-control colorpicker" type="text" :id="field.db_title" v-on:change="error = ''">
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-color',{
		template: '#template-field-color',
		props:['field'],
		components: {},
		data: function () {
			return {
				error: '',
			}
		},
		methods: {
			check: function(){

				if (!this.field.value)
					this.field.value = '#000000'

				return true
			},
		},
		mounted: function(){
			
			let color = '#000000'

			if (!this.field.value)
				color = this.field.value

			$('#' + this.field.db_title).spectrum({
				color: color,
				change: function(color) {
					this.field.value = color.toHexString()
				}
			})
		},
	})
</script>