<script type="text/x-template" id="template-field-photo">
	<div class="row form-group" v-on:dragenter="dragenter" v-on:dragleave="dragleave" v-on:dragover="dragover" v-on:drop="drop">
		<label class="col-sm-2 control-label" v-text="field.title"></label>
		<div class="col-sm-10">
			<input class="form-control" type="text" :id="field.db_title" v-model="field.value" v-on:change="error = ''">
			<div class="photo-preview-wrapper">
				<img :src="field.value" alt="" class="photo-preview-img">
				<div class="btn btn-primary" v-on:click="add_photo(field.db_title)">Add photo</div>
			</div>
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-photo',{
		template: '#template-field-photo',
		props:['field'],
		components: {},
		data: function () {
			return {
				error: '',
			}
		},
		methods: {
			dragenter: function(e){
				e.preventDefault()
				e.stopPropagation()
			},
			dragleave: function(e){
				e.preventDefault()
				e.stopPropagation()
			},
			dragover: function(e){
				e.preventDefault()
				e.stopPropagation()
			},
			drop: async function(e){
				e.preventDefault()
				e.stopPropagation()
				
				if (e.buttons == 0 && e.dataTransfer.items.length > 0) {

					const img = e.dataTransfer.items[0]

					if (img.type.match(/image.*/)) {

						const image_file = img.getAsFile()

						const response = await post('/admin/upload-image', {
							upload: image_file,
						}, true)

						const obj = JSON.parse(response.data)

						if (obj.url) {

							this.field.value = '/' + obj.url

						} else {

							alert('Error')
						}

					} else {
						alert('File have to be image')
					}
				}
			},
			check: function(){

				if (this.field.required != 'optional' && !this.file.value) {
					this.error = 'This field is required'
				} else if (this.field.required == 'required_once') {
					// TODO
				}

				if (!this.field.value)
					this.field.value = ''

				return true
			},
			add_photo: function(id){

				window.open('/laravel-filemanager?type=image', 'FileManager', 'width=900,height=600');
				window.SetUrl = (items)=>{

					for (var i = 0; i < items.length; i++) {

						var url = items[i].url.replace(document.location.origin, '')

						this.field.value = url

						break;
					}
				};
			},
		},
	})
</script>