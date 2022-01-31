<script type="text/x-template" id="template-field-gallery">
	<div class="form-group">
		
		<div class="field-title">
			<label class="edit-field-title control-label" v-text="field.title"></label>
			
			<div class="field-remark" v-if="field.remark">
				i
				<div class="field-remark-modal" v-text="field.remark"></div>
			</div>
		</div>

		<div class="edit-field-inner">
			<template v-for="(item, index) in field.value">
				<input class="form-control gallery-margin-top" type="text" v-model="field.value[index]">
				<div class="photo-preview-wrapper">
					<img :src="field.value[index]" alt="" class="photo-preview-img">
					<div class="btn-delete-photo" v-on:click="remove_gallery(index)">
						<svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M4.88111 4.00023L7.8722 1.00901C7.95447 0.926667 7.99987 0.816813 8 0.699675C8 0.582472 7.9546 0.472488 7.8722 0.390277L7.61008 0.128228C7.52767 0.0456915 7.41782 0.000488281 7.30055 0.000488281C7.18348 0.000488281 7.07363 0.0456915 6.99122 0.128228L4.00013 3.11925L1.00891 0.128228C0.926634 0.0456915 0.816715 0.000488281 0.699512 0.000488281C0.582439 0.000488281 0.47252 0.0456915 0.390244 0.128228L0.128 0.390277C-0.0426667 0.560944 -0.0426667 0.838537 0.128 1.00901L3.11915 4.00023L0.128 6.99132C0.0456585 7.07379 0.000325203 7.18364 0.000325203 7.30078C0.000325203 7.41792 0.0456585 7.52777 0.128 7.61018L0.390179 7.87223C0.472455 7.9547 0.582439 7.99997 0.699447 7.99997C0.81665 7.99997 0.926569 7.9547 1.00885 7.87223L4.00006 4.88114L6.99115 7.87223C7.07356 7.9547 7.18341 7.99997 7.30049 7.99997H7.30062C7.41776 7.99997 7.52761 7.9547 7.61002 7.87223L7.87213 7.61018C7.95441 7.52784 7.9998 7.41792 7.9998 7.30078C7.9998 7.18364 7.95441 7.07379 7.87213 6.99138L4.88111 4.00023Z" fill="#7F7F7F"/>
						</svg>
					</div>
				</div>
			</template>
			<div class="btn btn-primary gallery-margin-top" v-on:click="add_gallery()">Добавить</div>
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

						url = decodeURIComponent(url) //url.pathname
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