<script type="text/x-template" id="template-field-gallery">
	<div class="row form-group">
		<label class="col-sm-2 control-label" v-text="field.title"></label>
		<div class="col-sm-10">
			<template v-for="(item, index) in field.value">
				<input class="form-control gallery-margin-top" type="text" v-model="field.value[index]">
				<div class="photo-preview-wrapper">
					<img :src="field.value[index]" alt="" class="photo-preview-img">
					<div class="btn btn-danger" v-on:click="remove_gallery(index)">Delete photo</div>
				</div>
			</template>
			<div class="btn btn-primary gallery-margin-top" v-on:click="add_gallery()">Add photos</div>
			<div class="input-error" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-gallery',{
		template: '#template-field-gallery',
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
					this.field.value = []

				return true
			},
			add_gallery: function(){
				window.open('/laravel-filemanager?type=image', 'FileManager', 'width=900,height=600');
				window.SetUrl = (items)=>{

					if (this.field.value)
						var arr = this.field.value
					else  var arr = []
					
					for (var i = 0; i < items.length; i++) {
						var url = items[i].url.replace(/^.*\/\/[^\/]+/, '')
						url = decodeURIComponent(url.pathname)
						
						arr.push(url)
					}
					this.field.value = arr
					this.$forceUpdate()
				};
			},
			remove_gallery: function(index){
				this.field.value.splice(index, 1)
				this.$forceUpdate()
			},
		},
	})
</script>