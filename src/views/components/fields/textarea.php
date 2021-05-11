<script type="text/x-template" id="template-field-textarea">
	<div class="row form-group">
		<label class="col-sm-2 control-label" v-text="field.title"></label>
		<div class="col-sm-10">
			<textarea v-on:input="change" :rows="textarea_height" class="form-control" v-model="field.value" maxlength="6500"></textarea>
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-textarea',{
		template: '#template-field-textarea',
		props:['field'],
		components: {},
		data: function () {
			return {
				error: '',
				textarea_height: 1,
			}
		},
		methods: {
			check: function(){

				if (this.field.required != 'optional' && !this.field.value) {
					this.error = 'This field is required'
				} else if (this.field.required == 'required_once') {
					// TODO
				}
									
				if (this.field.value.length > 6500)
					this.error = 'More than maxlength (6500 symbols)'

				if (this.error == '')
					return true
				return false
			},
			change: function(e){

				let count = (this.field.value.match(/\n/g) || []).length
				
				this.textarea_height = count + 1

				if (this.field.db_title == 'title') {
					this.$root.$emit('title_changed', e.target.value)
				}
			},
		},
	})
</script>