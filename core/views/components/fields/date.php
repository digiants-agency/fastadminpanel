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
			<input class="form-control datepicker" data-init="0" type="text" :id="field.db_title" v-on:change="error = ''">
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-date',{
		template: '#template-field-date',
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
					this.field.value = '2000-01-01'
				return true
			},
		},
		mounted: function(){

			const app = this
			const today = new Date()
			let date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate()

			if (this.field.value)
				date = this.field.value
			else this.field.value = date

			if ($('#' + this.field.db_title).attr('data-init') == "0") {

				$('#' + this.field.db_title).datepicker({
					dateFormat: "yy-mm-dd",
					onSelect: function(text) {
						app.field.value = text
					}
				})
				$('#' + this.field.db_title).attr('data-init', '1')
			}

			$('#' + this.field.db_title).datepicker( "setDate", date )
		},
	})
</script>