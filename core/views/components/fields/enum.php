<script type="text/x-template" id="template-field-enum">
	<div class="form-group">
		
		<div class="field-title">
			<label class="edit-field-title control-label" v-text="field.title"></label>
			
			<div class="field-remark" v-if="field.remark">
				i
				<div class="field-remark-modal" v-text="field.remark"></div>
			</div>
		</div>

		<div class="edit-field-inner">
			<select class="form-control" v-model="value">
				<option :value="field.enum[index]" v-for="(item, index) in field.enum" v-text="field.enum[index]"></option>
			</select>
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-enum', {
		template: '#template-field-enum',
		props: ['field', 'pointer'],
		mixins: [recursiveFieldMixin],
		components: {},
		data() {
			return {
				error: '',
			}
		},
		methods: {
			check() {

				return true
			},
		},
		mounted() {
			if (!this.value && this.field.enum.length > 0) {
				this.value = this.field.enum[0]
			}
		},
	})
</script>