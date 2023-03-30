<script type="text/x-template" id="template-dropdown">
	<div class="table-edit">
		<div>
			<div class="col-sm-12">
				<h1>Edit dropdowns</h1>
			</div>
			<div class="table-wrapper">
				<table class="table">
					<tr>
						<td class="table-header-title">ID</td>
						<td class="table-header-title">Title</td>
						<td class="table-header-title">Priority</td>
						<td class="table-header-title">Icon</td>
						<td class="table-header-title"></td>
					</tr>

					<tr class="table-dropdown-item" v-for="(elm, index) in dropdown">
						<td>
							<div class="dropdown-td-wrapper" v-text="elm.id"></div>
						</td>
						<td>
							<div class="dropdown-td-wrapper">
								<input v-model="elm.title" type="text" class="form-control title" placeholder="Title">
							</div>
						</td>
						<td>
							<div class="dropdown-td-wrapper">
								<input v-model="elm.sort" type="text" class="form-control title" placeholder="Priority">
							</div>
						</td>
						<td>
							<div class="dropdown-td-wrapper">
								<div class="edit-field-inner">
									<input class="form-control" type="text" v-model="elm.icon">
									<div class="photo-preview-wrapper">
										<img :src="elm.icon" alt="" class="photo-preview-img">
										<div class="btn btn-primary" v-on:click="add_photo(index)">Add</div>
									</div>
								</div>
							</div>
						</td>
						<td>
							<div class="dropdown-td-wrapper">
								<div v-on:click="rm(index)" class="rem btn btn-danger btn-small">
									<svg class="btn-svg" width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M4.88111 4.00014L7.8722 1.00892C7.95447 0.926576 7.99987 0.816722 8 0.699584C8 0.58238 7.9546 0.472397 7.8722 0.390185L7.61008 0.128137C7.52767 0.0456 7.41782 0.000396729 7.30055 0.000396729C7.18348 0.000396729 7.07363 0.0456 6.99122 0.128137L4.00013 3.11916L1.00891 0.128137C0.926634 0.0456 0.816715 0.000396729 0.699512 0.000396729C0.582439 0.000396729 0.47252 0.0456 0.390244 0.128137L0.128 0.390185C-0.0426667 0.560852 -0.0426667 0.838445 0.128 1.00892L3.11915 4.00014L0.128 6.99123C0.0456585 7.0737 0.000325203 7.18355 0.000325203 7.30069C0.000325203 7.41783 0.0456585 7.52768 0.128 7.61009L0.390179 7.87214C0.472455 7.95461 0.582439 7.99988 0.699447 7.99988C0.81665 7.99988 0.926569 7.95461 1.00885 7.87214L4.00006 4.88105L6.99115 7.87214C7.07356 7.95461 7.18341 7.99988 7.30049 7.99988H7.30062C7.41776 7.99988 7.52761 7.95461 7.61002 7.87214L7.87213 7.61009C7.95441 7.52775 7.9998 7.41783 7.9998 7.30069C7.9998 7.18355 7.95441 7.0737 7.87213 6.99129L4.88111 4.00014Z" fill="white"/>
									</svg>
								</div>
							</div>
						</td>
					</tr>
				</table>

				<button v-on:click="add" type="button" class="btn btn-add">Add dropdown +</button>

				</div>
			</div>
			
			<button v-on:click="update()" class="btn btn-primary">Save</button>
		</div>

	</div>
</script>
	
<script>
	Vue.component('template-dropdown',{
		template: '#template-dropdown',
		data: function () {
			return {
				dropdown: [],
			}
		},
		methods: {
			add: function(){
				var id = 1
				if (this.dropdown.length > 0) {
					id = this.dropdown[this.dropdown.length - 1].id + 1
				}
				this.dropdown.push({
					id: id,
					title: '',
					sort: 0,
					icon: '',
				})
			},
			rm: function(index) {
				this.dropdown.splice(index, 1)
			},
			update: function(){
				request('/admin/update-dropdown', {
					dropdown: this.dropdown,
				}, (data)=>{
					location.reload()
				})
			},

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

							this.menu_item_edit.icon = '/' + obj.url

						} else {

							alert('Error')
						}

					} else {
						alert('File have to be image')
					}
				}
			},
			check: function(){

				if (!this.menu_item_edit.icon)
					this.menu_item_edit.icon = ''

				return true
			},
			add_photo: function(index){

				window.open('/laravel-filemanager?type=admin', 'FileManager', 'width=900,height=600');
				window.SetUrl = (items)=>{

					for (var i = 0; i < items.length; i++) {

						var url = items[i].url.replace(/^.*\/\/[^\/]+/, '')
						
						this.dropdown[index].icon = decodeURIComponent(url)
						break;
					}
				};


			},
		},
		watch: {
		},
		created: function(){
			request('/admin/db-select', {
				table: 'dropdown',
				limit: 0,
			}, (data)=>{
				this.dropdown = data.instances
			})
		},
		beforeDestroy: function(){
		},
	})
</script>