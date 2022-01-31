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
			<input class="form-control datetimepicker" data-init="0" type="text" :id="field.db_title" v-on:change="error = ''">
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-datetime',{
		template: '#template-field-datetime',
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
					this.field.value = '2000-01-01 12:00:00'
				return true
			},
		},
		mounted: function(){

			const app = this
			const today = new Date()
			let date = today.getFullYear()+'/'+(today.getMonth()+1)+'/'+today.getDate()+' '+today.getHours()+':'+today.getMinutes()

			if (this.field.value)
				date = this.field.value
			else this.field.value = date

			if ($('#' + this.field.db_title).attr('data-init') == "0") {

				$('#' + this.field.db_title).datetimepicker({
					format: "Y-m-d H:i",
					onChangeDateTime: function(d) {
						const save_date = new Date(d.getTime() - d.getTimezoneOffset() * 60 * 1000);
						app.field.value = save_date.getUTCFullYear() + '-' +
							('00' + (save_date.getUTCMonth()+1)).slice(-2) + '-' +
							('00' + save_date.getUTCDate()).slice(-2) + ' ' + 
							('00' + save_date.getUTCHours()).slice(-2) + ':' + 
							('00' + save_date.getUTCMinutes()).slice(-2) + ':' + 
							('00' + save_date.getUTCSeconds()).slice(-2)
					}
				})
				$('#' + this.field.db_title).attr('data-init', '1')
			}
			
			$('#' + this.field.db_title).val( date )
		},
	})
</script>