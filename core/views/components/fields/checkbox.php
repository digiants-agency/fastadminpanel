<script type="text/x-template" id="template-field-checkbox">
	<div class="form-group">
		
		<div class="field-title">
			<label class="edit-field-title control-label" v-text="field.title"></label>
			
			<div class="field-remark" v-if="field.remark">
				i
				<div class="field-remark-modal" v-text="field.remark"></div>
			</div>
		</div>

		<div class="edit-field-inner">
			<label class="checkbox">
				<input class="checkbox-input form-control form-control-checkbox" type="checkbox" style="display: none;" v-model="field.value">

                <div class="checkbox-rectangle">
                    <svg class="checkbox-mark" enable-background="new 0 0 515.556 515.556" height="512" viewBox="0 0 515.556 515.556" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m0 274.226 176.549 176.886 339.007-338.672-48.67-47.997-290.337 290-128.553-128.552z" fill="white"/></svg>
                </div>
            </label>
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