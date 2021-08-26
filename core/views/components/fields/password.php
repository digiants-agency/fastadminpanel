<script type="text/x-template" id="template-field-password">
	<div class="row form-group">
		<label class="col-sm-2 control-label" v-text="field.title"></label>
		<div class="col-sm-10">
			<input class="form-control" type="password" v-model="field.value" v-on:change="error = ''" maxlength="191">
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-password',{
		template: '#template-field-password',
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
					this.field.value = ''

				return true
			},
		},
	})
</script>