<script type="text/x-template" id="template-menu">
	<div class="table-edit">
		<h1>Create or edit CRUD menu item</h1>
		<div class="menu-table">
			<div class="form-group">
				<label class="menu-item-title">Menu item</label>
				<div class="menu-item-input">
					<div class="select-wrapper">
						<select v-on:change="set_menu_item" class="form-control">
							<option :value="-1">New</option>
							<option :value="index" v-for="(item, index) in menu" v-if="item.type == 'multiple'" v-text="item.title"></option>
						</select>
						<div class="select-arrow-block">
							<svg class="select-arrow" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
								<clipPath id="clip0_755_2893">
								<rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
								</clipPath>
							</svg>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="menu-item-title">CRUD name</label>
				<div class="menu-item-input">
					<input v-model="menu_item_edit.table_name" class="form-control" placeholder="ex. books or products (used to generate DB table)" type="text" :disabled="action != 'create'">
				</div>
			</div>
			<div class="form-group">
				<label class="menu-item-title">CRUD title</label>
				<div class="menu-item-input">
					<input v-model="menu_item_edit.title" class="form-control" placeholder="Menu title (used for menu item)" type="text">
				</div>
			</div>
			<div class="form-group disabled">
				<label class="menu-item-title">Soft delete?</label>
				<div class="menu-item-input">
					<div class="select-wrapper">
						<select v-model="menu_item_edit.is_soft_delete" class="form-control">
							<option value="0">No</option>
							<option value="1">Yes</option>
						</select>
						<div class="select-arrow-block">
							<svg class="select-arrow" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
								<clipPath id="clip0_755_2893">
								<rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
								</clipPath>
							</svg>
						</div>
					</div>

				</div>
			</div>
			<div class="form-group">
				<label class="menu-item-title">Is dev</label>
				<div class="menu-item-input">
					<div class="select-wrapper">
						<select v-model="menu_item_edit.is_dev" class="form-control">
							<option value="0">No</option>
							<option value="1">Yes</option>
						</select>
						<div class="select-arrow-block">
							<svg class="select-arrow" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
								<clipPath id="clip0_755_2893">
								<rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
								</clipPath>
							</svg>
						</div>
					</div>

				</div>
			</div>
			<div class="form-group">
				<label class="menu-item-title">Multilanguage</label>
				<div class="menu-item-input">
					<div class="select-wrapper">
						<select v-model="menu_item_edit.multilanguage" class="form-control">
							<option :value="0">No</option>
							<option :value="1">Yes</option>
						</select>
						<div class="select-arrow-block">
							<svg class="select-arrow" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
								<clipPath id="clip0_755_2893">
								<rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
								</clipPath>
							</svg>
						</div>
					</div>

				</div>
			</div>
			<div class="form-group">
				<label class="menu-item-title">Sort</label>
				<div class="menu-item-input">
					<input v-model="menu_item_edit.sort" class="form-control" placeholder="0" type="text">
				</div>
			</div>
			<div class="form-group">
				<label class="menu-item-title">Parent</label>
				<div class="menu-item-input">
					<div class="select-wrapper">
						<select v-model="menu_item_edit.parent" class="form-control">
							<option value="0">None</option>
							<option :value="elm.id" v-for="elm in dropdown" v-text="elm.title"></option>
						</select>
						<div class="select-arrow-block">
							<svg class="select-arrow" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
								<clipPath id="clip0_755_2893">
								<rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
								</clipPath>
							</svg>
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="menu-item-title">Icon</label>
				<div class="edit-field-inner">
					<input class="form-control" type="text" v-model="menu_item_edit.icon">
					<div class="photo-preview-wrapper">
						<img :src="menu_item_edit.icon" alt="" class="photo-preview-img">
						<div class="btn btn-primary" v-on:click="add_photo()">Добавить</div>
					</div>
				</div>
			</div>

		</div>

		<h1>Edit fields</h1>
		<div class="menu-table-editfields">
			<table class="table">
				<tr>
					<td class="table-header-title">Is visible?</td>
					<td class="table-header-title">Lang</td>
					<td class="table-header-title">Show in list</td>
					<td class="table-header-title">Field type</td>
					<td class="table-header-title">Field DB name</td>
					<td class="table-header-title">Field visual name</td>
					<td class="table-header-title"></td>
					<td class="table-header-title"></td>
				</tr>
				<tr v-for="(field, index) in menu_item_edit.fields">
					<td class="menu-table-field">
						<!-- <input v-model="field.is_visible" type="checkbox" class="show-checked"> -->
						<div class="menu-table-field-td-wrapper">
							<label class="checkbox">
								<input class="checkbox-input" v-model="field.is_visible" style="display: none;" type="checkbox">
								<div class="checkbox-rectangle">
									<svg class="checkbox-mark" enable-background="new 0 0 515.556 515.556" height="512" viewBox="0 0 515.556 515.556" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m0 274.226 176.549 176.886 339.007-338.672-48.67-47.997-290.337 290-128.553-128.552z" fill="white"/></svg>
								</div>
							</label>
						</div>
					</td>
					
					<td class="menu-table-field">
					<div class="menu-table-field-td-wrapper">

						<div class="select-wrapper">
							<select v-model="field.lang" class="form-control type">
								<option value="1">Separate</option>
								<option value="0">Common</option>
							</select>
							<div class="select-arrow-block">
								<svg class="select-arrow" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
									<clipPath id="clip0_755_2893">
									<rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
									</clipPath>
								</svg>
							</div>
						</div>
					</div>

					</td>
					<td class="menu-table-field">
						<div class="menu-table-field-td-wrapper">

							<div class="select-wrapper">
								<select v-model="field.show_in_list" class="form-control type">
									<option value="no">No</option>
									<option value="yes">Yes</option>
									<option value="editable">Editable</option>
								</select>
								<div class="select-arrow-block">
									<svg class="select-arrow" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
										<clipPath id="clip0_755_2893">
										<rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
										</clipPath>
									</svg>
								</div>
							</div>
						</div>

					</td>
					<td class="menu-table-field">
						<div class="menu-table-field-td-wrapper">

							<div class="select-wrapper">
								<select v-model="field.type" class="form-control type">
									<option value="text">Text</option>
									<option value="textarea">Long text</option>
									<option value="ckeditor">Ckeditor</option>
									<option value="checkbox">Checkbox</option>
									<option value="color">Color picker</option>
									<option value="date">Date picker</option>
									<option value="datetime">Date and time picker</option>
									<option value="relationship">Relationship</option>
									<option value="file">File</option>
									<option value="photo">Photo</option>
									<option value="gallery">Gallery</option>
									<option value="password">Password (hashed)</option>
									<option value="money">Money</option>
									<option value="number">Number</option>
									<option value="enum">Select (ENUM)</option>
									<option value="repeat">Repeat (unaviable)</option>
									<option value="translater">Translater (deprecated)</option>
								</select>
								<div class="select-arrow-block">
									<svg class="select-arrow" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
										<clipPath id="clip0_755_2893">
										<rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
										</clipPath>
									</svg>
								</div>
							</div>
						</div>
					</td>
					<td class="menu-table-field">
						<div class="menu-table-field-td-wrapper">
							<input v-if="field.type != 'relationship' && field.type != 'enum'" v-model="field.db_title" type="text" class="form-control title" placeholder="Название">
							<div v-else-if="field.type == 'relationship'">
								<div class="select-wrapper">

									<select v-model="field.relationship_count" class="form-control type" title="One to many require Single relation on other table">
										<option value="single">Single</option>
										<option value="many">Many</option>
										<option value="editable">One to many</option>
									</select>
									<div class="select-arrow-block">
										<svg class="select-arrow" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
											<clipPath id="clip0_755_2893">
											<rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
											</clipPath>
										</svg>
									</div>
								</div>
								<div class="select-wrapper">

									<select v-model="field.relationship_table_name" class="form-control type">
										<option :value="item.table_name" v-for="(item, index) in menu" v-text="item.title"></option>
									</select>
									<div class="select-arrow-block">
										<svg class="select-arrow" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
											<clipPath id="clip0_755_2893">
											<rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
											</clipPath>
										</svg>
									</div>
								</div>
								<div v-if="field.relationship_table_name && field.relationship_count != 'editable'">
									<div class="select-wrapper">

										<select v-model="field.relationship_view_field" class="form-control type">
											<option :value="item.db_title" v-for="(item, index) in get_fields_by_table_name(field.relationship_table_name)" v-text="item.title"></option>
										</select>
										<div class="select-arrow-block">
											<svg class="select-arrow" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
												<clipPath id="clip0_755_2893">
												<rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
												</clipPath>
											</svg>
										</div>
									</div>
								</div>
							</div>
							<div v-else-if="field.type == 'enum'">
								<input v-model="field.db_title" type="text" class="form-control title" placeholder="Field DB name">
								<input v-for="(item, index) in field.enum" v-model="field.enum[index]" type="text" class="form-control title" placeholder="Element">
								<button class="btn-primary btn" v-on:click="add_enum(field.enum)">Add</button>
								<button class="btn-danger btn" v-on:click="remove_enum(field.enum)">Remove</button>
							</div>
						</div>
					</td>
					<td class="menu-table-field">
						<div class="menu-table-field-td-wrapper">
							<input v-model="field.title" type="text" class="form-control title" placeholder="Название">
						</div>
					</td>
					<td class="menu-table-field">
						<div class="menu-table-field-td-wrapper">

							<div class="select-wrapper">

								<select v-model="field.required" class="form-control type">
									<option value="optional">Optional</option>
									<option value="required">Required</option>
									<option value="required_unique">Required unique</option>
								</select>
								<div class="select-arrow-block">
									<svg class="select-arrow" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
										<clipPath id="clip0_755_2893">
										<rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
										</clipPath>
									</svg>
								</div>
							</div>
						</div>
					</td>
					<td class="menu-table-field">
						<div class="menu-table-field-td-wrapper">

							<div class="menu-table-flex-btns">
								<div v-on:click="up_menu_item(index)" class="btn btn-blue btn-small">
									<svg class="btn-svg" width="10" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M5.45962 0.54038C5.20578 0.28654 4.79422 0.28654 4.54038 0.54038L0.403806 4.67696C0.149965 4.9308 0.149965 5.34235 0.403806 5.59619C0.657647 5.85003 1.0692 5.85003 1.32304 5.59619L5 1.91924L8.67696 5.59619C8.9308 5.85003 9.34235 5.85003 9.59619 5.59619C9.85003 5.34235 9.85003 4.9308 9.59619 4.67696L5.45962 0.54038ZM5.65 9L5.65 1L4.35 1L4.35 9L5.65 9Z" fill="#171219"/>
									</svg>
								</div>
								<div v-on:click="remove_menu_item(index)" class="rem btn btn-danger btn-small">
									<svg class="btn-svg" width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M4.88111 4.00011L7.8722 1.00889C7.95447 0.926545 7.99987 0.816691 8 0.699553C8 0.58235 7.9546 0.472366 7.8722 0.390155L7.61008 0.128106C7.52767 0.0455695 7.41782 0.000366211 7.30055 0.000366211C7.18348 0.000366211 7.07363 0.0455695 6.99122 0.128106L4.00013 3.11913L1.00891 0.128106C0.926634 0.0455695 0.816715 0.000366211 0.699512 0.000366211C0.582439 0.000366211 0.47252 0.0455695 0.390244 0.128106L0.128 0.390155C-0.0426667 0.560821 -0.0426667 0.838415 0.128 1.00889L3.11915 4.00011L0.128 6.9912C0.0456585 7.07367 0.000325203 7.18352 0.000325203 7.30066C0.000325203 7.4178 0.0456585 7.52765 0.128 7.61006L0.390179 7.87211C0.472455 7.95458 0.582439 7.99985 0.699447 7.99985C0.81665 7.99985 0.926569 7.95458 1.00885 7.87211L4.00006 4.88102L6.99115 7.87211C7.07356 7.95458 7.18341 7.99985 7.30049 7.99985H7.30062C7.41776 7.99985 7.52761 7.95458 7.61002 7.87211L7.87213 7.61006C7.95441 7.52772 7.9998 7.4178 7.9998 7.30066C7.9998 7.18352 7.95441 7.07367 7.87213 6.99126L4.88111 4.00011Z" fill="white"/>
									</svg>
								</div>
							</div>
						</div>
					</td>
				</tr>
			</table>

			<button v-on:click="add_menu_item()" type="button" id="addField" class="btn btn-add"><span class="btn-plus">+</span> Add one more field</button>

		</div>

		
		<div class="form-group">
			<div class="col-md-12">
				<button v-if="action == 'create'" v-on:click="create_crud()" class="btn btn-primary">Create CRUD</button>
				<div v-else class="sides">
					<button v-on:click="update_crud()" class="btn btn-primary">Update CRUD</button>
					<button v-on:click="remove_crud()" class="btn btn-danger">Remove CRUD</button>
				</div>
			</div>
		</div>
	</div>
</script>
	
<script>
	Vue.component('template-menu',{
		template: '#template-menu',
		data: function () {
			return {
				menu: [],
				action: 'create',
				to_remove: [],
				template: {
					table_name: '',
					title: '',
					is_soft_delete: 0,
					is_dev: 0,
					multilanguage: 1,
					sort: 10,
					fields: [],
				},
				menu_item_edit: {
					table_name: '',
					title: '',
					is_soft_delete: 0,
					is_dev: 0,
					multilanguage: 1,
					sort: 10,
					fields: [],
					icon: '',
				},
				dropdown: [],
			}
		},
		methods: {
			set_menu_item: function(e){
				var id = e.target.value

				if (id == -1) {
					this.menu_item_edit = Object.assign({}, this.template)
					this.action = 'create'
				} else {
					this.menu_item_edit = this.menu[id]
					this.to_remove = []
					this.action = 'edit'
				}

				console.log(this.menu_item_edit)
			},
			remove_menu_item: function(index) {
				this.to_remove.push(this.menu_item_edit.fields[index].id)
				this.menu_item_edit.fields.splice(index, 1)
			},
			up_menu_item: function(index) {
				if (index > 0) {
					var temp = this.menu_item_edit.fields[index]
					this.menu_item_edit.fields[index] = this.menu_item_edit.fields[index - 1]
					this.menu_item_edit.fields[index - 1] = temp
					this.$forceUpdate()
				}
			},
			add_menu_item: function(){

				var id = 0
				if (this.menu_item_edit.fields.length > 0) {
					for (var i = 0; i < this.menu_item_edit.fields.length; i++) {
						if (this.menu_item_edit.fields[i].id > id)
							id = this.menu_item_edit.fields[i].id
					}
					id++
				}

				this.menu_item_edit.fields.push({id: id, required: 'optional', is_visible: true, lang: 1, show_in_list: 'no'})
			},
			create_crud: function(){
				
				request('/admin/db-create-table', {
					table_name: this.menu_item_edit.table_name, 
					title: this.menu_item_edit.title,
					is_soft_delete: this.menu_item_edit.is_soft_delete,
					is_dev: this.menu_item_edit.is_dev,
					multilanguage: this.menu_item_edit.multilanguage,
					sort: this.menu_item_edit.sort,
					parent: this.menu_item_edit.parent,
					fields: JSON.stringify(this.menu_item_edit.fields),
					icon: this.menu_item_edit.icon
				}, (data)=>{
					if (data == 'Success') {
						location.reload()
					}
				})
			},
			update_crud: function(){

				// this.fix_ids()

				request('/admin/db-update-table', {
					id: this.menu_item_edit.id,
					table_name: this.menu_item_edit.table_name, 
					title: this.menu_item_edit.title,
					is_soft_delete: this.menu_item_edit.is_soft_delete,
					is_dev: this.menu_item_edit.is_dev,
					multilanguage: this.menu_item_edit.multilanguage,
					sort: this.menu_item_edit.sort,
					parent: this.menu_item_edit.parent,
					fields: JSON.stringify(this.menu_item_edit.fields),
					to_remove: JSON.stringify(this.to_remove),
					icon: this.menu_item_edit.icon
				}, (data)=>{
					if (data == 'Success') {
						location.reload()
					}
				})
			},
			remove_crud: function(){

				if (confirm("Are you sure?")) {
					request('/admin/db-remove-table', {
						id: this.menu_item_edit.id,
						table_name: this.menu_item_edit.table_name, 
					}, (data)=>{
						if (data == 'Success') {
							location.reload()
						}
					})
				}
			},
			get_fields_by_table_name: function(table_name){

				var fields = []

				this.menu.forEach((elm)=>{
					if (elm.table_name == table_name) {
						fields = elm.fields
						return
					}
				})

				return fields
			},
			add_enum: function(select){
				select.push('')
				this.$forceUpdate()
			},
			remove_enum: function(select){
				select.splice(-1,1)
				this.$forceUpdate()
			},
			fix_ids: function(){
				for (var j = 0; j < this.menu_item_edit.fields.length; j++) {
					this.menu_item_edit.fields[j].id = j
				}
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
			add_photo: function(){

				window.open('/laravel-filemanager?type=admin', 'FileManager', 'width=900,height=600');
				window.SetUrl = (items)=>{

					for (var i = 0; i < items.length; i++) {

						var url = items[i].url.replace(/^.*\/\/[^\/]+/, '')
						
						this.menu_item_edit.icon = decodeURIComponent(url)
						break;
					}
				};

			},
		},
		watch: {
			'menu_item_edit.fields': function(fields){
				fields.forEach((field)=>{
					if (field.type == 'enum' && field.enum == undefined) {
						field.enum = []
					} else if (field.type != 'enum' && field.enum != undefined) {
						delete field.enum;
					}
				})
			}
		},
		created: function(){
			if (app) {
				this.menu = app.menu
			} else {
				this.$root.$on('menu_init',(menu)=>{
					this.menu = menu
				})
			}
			request('/admin/db-select', {
				table: 'dropdown',
				limit: 0,
			}, (data)=>{
				this.dropdown = data.instances
			})
		},
		beforeDestroy: function(){
			this.$root.$off('menu_init')
		},
	})
</script>