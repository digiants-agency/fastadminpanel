<script type="text/x-template" id="template-field-checkbox">
	<div class="row form-group">
		<label class="col-sm-2 control-label" v-text="field.title"></label>
		<div class="col-sm-10">
			<input class="form-control form-control-checkbox" type="checkbox" v-model="field.value">
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-checkbox',{
		template: '#template-field-checkbox',
		props:['field'],
		components: {},
		data: function () {
			return {
				error: '',
			}
		},
		methods: {
			check: function(){

				if (!this.field.value) {
					this.field.value = 0
				}

				return true
			},
		},
	})
</script>