<template id="dropdowns">
	<div class="table-edit">
		<div class="col-sm-12">
			<h1>Edit dropdowns</h1>
		</div>
		<div class="table-wrapper">
			<table class="table">
				<tr>
					<td class="table-header-title">Slug</td>
					<td class="table-header-title">Title</td>
					<td class="table-header-title">Priority</td>
					<td class="table-header-title">Icon</td>
					<td class="table-header-title"></td>
				</tr>
				<tr class="table-dropdown-item" v-for="dropdown in dropdownsStore.dropdowns">
					<td>
						<div class="dropdown-td-wrapper">
							<input v-model="dropdown.slug" type="text" class="form-control title" placeholder="orders">
						</div>
					</td>
					<td>
						<div class="dropdown-td-wrapper">
							<input v-model="dropdown.title" type="text" class="form-control title" placeholder="Orders">
						</div>
					</td>
					<td>
						<div class="dropdown-td-wrapper">
							<input v-model="dropdown.sort" type="text" class="form-control title" placeholder="1">
						</div>
					</td>
					<td>
						<div class="dropdown-td-wrapper">
							<div class="edit-field-inner">
								<input class="form-control" type="text" v-model="dropdown.icon">
								<div class="photo-preview-wrapper">
									<img :src="dropdown.icon" alt="" class="photo-preview-img">
									<div class="btn btn-primary" v-on:click="changePhoto(dropdown)">Add</div>
								</div>
							</div>
						</div>
					</td>
					<td>
						<div class="dropdown-td-wrapper">
							<div class="rem btn btn-danger btn-small" v-on:click="dropdownsStore.remove(dropdown.slug)">
								<img class="btn-svg" src="/vendor/fastadminpanel/images/close.svg" alt="">
							</div>
						</div>
					</td>
				</tr>
			</table>
			<button type="button" class="btn btn-add" v-on:click="dropdownsStore.add()">Add dropdown +</button>
		</div>
		<button class="btn btn-primary" v-on:click="dropdownsStore.update()">Save</button>
	</div>
</template>
	
<script>
const dropdownsPage = {
	template: '#dropdowns',
	mixins: [addFileMixin],
	props: [],
	data() {
		return {
		}
	},
	computed: {
		...Pinia.mapStores(useDropdownsStore)
	},
	watch: {
	},
	created() {
	},
	mounted() {
	},
	methods: {
		changePhoto(dropdown) {

			this.addFile((photo) => dropdown.icon = photo, 'admin')
		},
	},
}
</script>