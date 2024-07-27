<template id="single-edit">
	<div class="table-edit">
		<h1>{{__('fastadminpanel.gen_single_desc')}}</h1>
		<div class="menu-table">
			<div class="form-group">
				<label class="menu-item-title">{{__('fastadminpanel.gen_single_item')}}</label>
				<div class="menu-item-input">
					<div class="select-wrapper">
						<select v-on:change="setSingle" class="form-control">
							<option :value="-1">{{__('fastadminpanel.new')}}</option>
							<option :value="item.id" v-for="item in singlesStore.singles" v-text="item.title"></option>
						</select>
						<div class="select-arrow-block">
							<img class="select-arrow" src="/vendor/fastadminpanel/images/dropdown-ico.svg" alt="">
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="menu-item-title">{{__('fastadminpanel.single_name')}}</label>
				<div class="menu-item-input">
					<input v-model="single.slug" class="form-control" placeholder="ex. mainpage or phrases (used to generate API)" type="text" :disabled="action != 'create'">
				</div>
			</div>
			<div class="form-group">
				<label class="menu-item-title">{{__('fastadminpanel.single_title')}}</label>
				<div class="menu-item-input">
					<input v-model="single.title" class="form-control" placeholder="Single title (used for menu item)" type="text">
				</div>
			</div>
			<div class="form-group">
				<label class="menu-item-title">Sort</label>
				<div class="menu-item-input">
					<input v-model="single.sort" class="form-control" placeholder="0" type="text">
				</div>
			</div>
			<div class="form-group">
				<label class="menu-item-title">Dropdown</label>
				<div class="menu-item-input">
					<div class="select-wrapper">
						<select v-model="single.dropdown_slug" class="form-control">
							<option :value="''">None</option>
							<option :value="dropdown.slug" v-for="dropdown in dropdownsStore.dropdowns" v-text="dropdown.title"></option>
						</select>
						<div class="select-arrow-block">
							<img class="select-arrow" src="/vendor/fastadminpanel/images/dropdown-ico.svg" alt="">
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="menu-item-title">Icon</label>
				<div class="edit-field-inner">
					<input class="form-control" type="text" v-model="single.icon">
					<div class="photo-preview-wrapper">
						<img :src="single.icon" alt="" class="photo-preview-img">
						<div class="btn btn-primary" v-on:click="changePhoto()">Add</div>
					</div>
				</div>
			</div>
		</div>
		<h1>Edit fields</h1>
		<div v-for="(block, blockIndex) in single.blocks" class="menu-table-editblocks">
			<div class="table create-single-block-title-wrapper">
				<div class="flex a-center">
					<div class="table-col table-header-title">Block API name</div>
					<div class="table-col table-header-title">Block visual name</div>
				</div>
				<div class="flex a-center w-100">
					<div class="table-col menu-table-field">
						<div class="menu-table-field-td-wrapper">
							<input v-model="block.slug" type="text" class="form-control title" placeholder="Slug API ID">
						</div>
					</div>
					<div class="table-col menu-table-field">
						<div class="menu-table-field-td-wrapper">
							<input v-model="block.title" type="text" class="form-control title" placeholder="Title">
						</div>
					</div>
					<div class="table-col table-col-last menu-table-field">
						<div class="menu-table-field-td-wrapper">
							<div class="menu-table-flex-btns">
								<div v-on:click="upBlock(blockIndex)" class="btn btn-blue btn-small">
									<img src="/vendor/fastadminpanel/images/up.svg" alt="" class="btn-svg">
								</div>
								<div v-on:click="removeBlock(blockIndex)" class="rem btn btn-danger btn-small">
									<img src="/vendor/fastadminpanel/images/close.svg" alt="" class="btn-svg">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<single-edit-fields :block="block" :index="blockIndex" v-on:blockchanged="blockChanged"/>
		</div>
		<button v-on:click="addBlock()" type="button" id="addBlock" class="btn btn-add"><span class="btn-plus">+</span> Add block</button>
		<div class="form-group">
			<div class="col-md-12">
				<button v-if="action == 'create'" v-on:click="updateSingle()" class="btn btn-primary">Create Single</button>
				<div v-else class="sides">
					<button v-on:click="updateSingle()" class="btn btn-primary">Update Single</button>
					<button v-on:click="removeSingle()" class="btn btn-danger">Remove Single</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
const singlesEditPage = {
	template: '#single-edit',
	mixins: [addFileMixin],
	props: [],
	data() {
		return {
			menu: [],
			action: 'create',
			single: this.getEmptySingle(),
		}
	},
	computed: {
		...Pinia.mapStores(useSinglesStore, useDropdownsStore),
	},
	watch: {
	},
	created() {
	},
	mounted() {
		this.singlesStore.fetchData(true)
	},
	methods: {
		getEmptySingle() {
			return {
				slug: '',
				title: '',
				sort: 10,
				blocks: [],
				icon: '',
			}
		},
		setSingle(e) {

			const id = e.target.value
			const single = this.singlesStore.singles.find(s => s.id == id)

			if (single) {
				this.single = single
				this.action = 'edit'
			} else {
				this.single = this.getEmptySingle()
				this.action = 'create'
			}
		},
		removeBlock(blockIndex) {

			this.single.blocks.splice(blockIndex, 1)
		},
		upBlock(blockIndex) {

			if (blockIndex > 0) {
				const temp = this.single.blocks[blockIndex]
				this.single.blocks[blockIndex] = this.single.blocks[blockIndex - 1]
				this.single.blocks[blockIndex - 1] = temp
				this.$forceUpdate()
			}
		},
		addBlock() {

			this.single.blocks.push({
				title: '',
				slug: '',
				fields: [],
			})
		},
		blockChanged(event) {

			this.single.blocks[event.index] = event.block
		},
		async updateSingle() {
			
			const response = await req.put("{{ route('admin-api-singles-update', [], false) }}", this.single)

			if (response.success) {
				location.reload()
			} else {
				alert('Error')
			}
		},
		async removeSingle() {

			if (confirm("Are you sure?")) {
				
				const response = await req.post("{{ route('admin-api-singles-destroy', [], false) }}", {
					slug: this.single.slug,
				})

				if (response.success) {
					location.reload()
				} else {
					alert('Error')
				}
			}
		},
		changePhoto() {

			this.addFile((photo) => this.single.icon = photo, 'admin')
		},
	},
}
</script>