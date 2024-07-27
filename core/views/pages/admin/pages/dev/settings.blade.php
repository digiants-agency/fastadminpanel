<template id="settings">
	<div class="settings">
		<div class="col-sm-12">
			<h1>Settings</h1>
		</div>
		<div class="menu-table settings-content">
			<div class="settings-group">
				<div class="settings-group-title">
					{{__('fastadminpanel.delete_lang')}}
				</div>
				<div class="settings-group-content">
					<select v-model="languageId" class="form-control settings-group-input">
						<option v-for="language in languageStore.all" :value="language.id" v-text="language.tag"></option>
					</select>
					<div class="btn btn-primary" v-on:click="languageStore.remove(languageId)">Delete</div>
				</div>
			</div>
			<div class="settings-group">
				<div class="settings-group-title">
					{{__('fastadminpanel.add_lang')}}
				</div>
				<div class="settings-group-content">
					<input v-model="languageTag" class="form-control settings-group-input" type="text" placeholder="en" maxlength="2" />
					<div class="btn btn-primary" v-on:click="languageStore.add(languageTag)">Add</div>
				</div>
			</div>
			<div class="settings-group">
				<div class="settings-group-title">
					Change main language
				</div>
				<div class="settings-group-content">
					<select v-model="languageId" class="form-control settings-group-input">
						<option v-for="language in languageStore.all" :value="language.id" v-text="language.tag"></option>
					</select>
					<div class="btn btn-primary" v-on:click="languageStore.saveMain(languageId)">Save</div>
				</div>
			</div>
			<div class="settings-group">
				<div class="settings-group-title">
					Permissions
				</div>
				<div class="settings-group-description">
					Warning: be careful with relations. Someone can use GET method with relation (and relation will not be checked for permission).<br>
					Superadmin role is: Entities = all, All = true.
				</div>
				<div class="settings-group-content fullwidth">
					<table class="settings-access-table">
						<tr class="settings-access-tr">
							<th class="settings-access-th">Entities</th>
							<th class="settings-access-th">Role</th>
							<th class="settings-access-th">Admin read</th>
							<th class="settings-access-th">Admin edit</th>
							<th class="settings-access-th">Api create</th>
							<th class="settings-access-th">Api read</th>
							<th class="settings-access-th">Api update</th>
							<th class="settings-access-th">Api delete</th>
							<th class="settings-access-th">All</th>
							<th class="settings-access-th"></th>
						</tr>
						<tr v-for="permission in rolesStore.permissions" class="settings-access-tr">
							<td class="settings-access-td">
								<select v-model="permission.slug" class="form-control default-arrow">
									<option :value="'all'">All</option>
									<option v-for="entity in entities" :value="entity.slug" v-text="entity.title"></option>
								</select>
							</td>
							<td class="settings-access-td">
								<select v-model="permission.id_roles" class="form-control default-arrow">
									<option :value="0">Guest</option>
									<option v-for="role in rolesStore.roles" :value="role.id" v-text="role.title"></option>
								</select>
							</td>
							<td v-for="mark in marks" class="settings-access-td">
								<div :class="{active: permission[mark] == 1}" class="checkbox-rectangle" v-on:click="permission[mark] = permission[mark] ? 0 : 1">
									<img src="/vendor/fastadminpanel/images/checkbox-mark.svg" alt="" class="checkbox-mark">
								</div>
							</td>
							<td class="settings-access-td">
								<div class="btn btn-danger btn-small">
									<img src="/vendor/fastadminpanel/images/close.svg" alt="" class="btn-svg">
								</div>
							</td>
						</tr>
						<tr class="settings-access-tr">
							<td class="settings-access-td" colspan="10">
								<div class="btn btn-primary" v-on:click="rolesStore.addPermission()">Add</div>
							</td>
						</tr>
					</table>
					<div class="btn btn-primary" v-on:click="rolesStore.updatePermissions()">Save</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
const settingsPage = {
	template: '#settings',
	props: [],
	data() {
		return {
			languageId: '',
			languageTag: '',
		}
	},
	computed: {
		...Pinia.mapStores(useLanguageStore, useCrudsStore, useSinglesStore, useRolesStore),
		entities() {

			const cruds = this.crudsStore.cruds.map(c => ({
				slug: c.table_name,
				title: c.title + " (crud)",
			}))

			const singles = this.singlesStore.singles.map(s => ({
				slug: s.slug,
				title: s.title + " (single)",
			}))

			return [...cruds, ...singles]
		},
		marks() {

			return ['admin_read', 'admin_edit', 'api_create', 'api_read', 'api_update', 'api_delete', 'all']
		},
	},
	watch: {
	},
	created() {
		this.languageId = this.languageStore.main.tag
	},
	mounted() {
	},
	methods: {
	},
}
</script>