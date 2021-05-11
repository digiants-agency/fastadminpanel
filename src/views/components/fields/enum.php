<script type="text/x-template" id="template-field-enum">
	<div class="row form-group">
		<label class="col-sm-2 control-label" v-text="field.title"></label>
		<div class="col-sm-10">
			<select class="form-control" v-model="field.value">
				<option :value="field.enum[index]" v-for="(item, index) in field.enum" v-text="field.enum[index]"></option>
			</select>
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-enum',{
		template: '#template-field-enum',
		props:['field'],
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
		mounted: function(){
			if (this.field.enum.length > 0) {
				this.field.value = this.field.enum[0]
			}
		},
	})
</script>