<script type="text/x-template" id="template-dropdown">
	<div class="table-edit">
		<div class="col-sm-12">
			<h1>Edit dropdown menu</h1>
		</div>
		<table class="table table-editfields">
			<tr>
				<td>ID</td>
				<td>Title</td>
				<td>Sort</td>
				<td></td>
			</tr>
			<tr v-for="(elm, index) in dropdown">
				<td v-text="elm.id"></td>
				<td>
					<input v-model="elm.title" type="text" class="form-control title" placeholder="Title">
				</td>
				<td>
					<input v-model="elm.sort" type="text" class="form-control title" placeholder="Sort">
				</td>
				<td>
					<div v-on:click="rm(index)" class="rem btn btn-danger">-</div>
				</td>
			</tr>
		</table>
		<hr>
		<div class="form-group">
			<div class="col-md-12">
				<button v-on:click="add" type="button" class="btn btn-success">Add</button>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<div class="sides">
					<button v-on:click="update()" class="btn btn-primary">Update</button>
				</div>
			</div>
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
		},
		watch: {
		},
		created: function(){
			request('/admin/db-select', {
				table: 'dropdown',
				limit: 0,
			}, (data)=>{
				this.dropdown = data
			})
		},
		beforeDestroy: function(){
		},
	})
</script>