<!DOCTYPE html>
<html lang="en">
	<head>
		@include('fastadminpanel.inc.head')
		@yield('head')
	</head>
	<body>
		<div id="app">
			<router-view></router-view>
			<div id="loader" :class="{active: loaderStore.isLoading}">
				<img src="/vendor/fastadminpanel/images/load.svg" alt="">
			</div>
		</div>
		
		@include('fastadminpanel.pages.admin.mixins.add-file')
		@include('fastadminpanel.pages.admin.mixins.find-field-component')
		@include('fastadminpanel.pages.admin.mixins.recursive-field')

		@include('fastadminpanel.stores.loader')
		@include('fastadminpanel.stores.user')
		@include('fastadminpanel.stores.languages')
		@include('fastadminpanel.stores.menu')
		@include('fastadminpanel.stores.roles')
		@include('fastadminpanel.stores.dropdowns')
		@include('fastadminpanel.stores.cruds')
		@include('fastadminpanel.stores.singles')

		<script>
			// remember order (full - https://vuejs.org/style-guide/rules-recommended.html):
			// 1) el/template
			// 2) components
			// 3) mixins
			// 4) props
			// 5) emits
			// 6) data
			// 7) computed
			// 8) watch
			// 9) created
			// 10) mounted
			// 11) unmounted
			// 12) methods
			const app = Vue.createApp({
				el: '#app',
				data() {
					return {
					}
				},
				computed: {
					...Pinia.mapStores(useLoaderStore)
				},
			})
		</script>
		
		@include('fastadminpanel.plugins.ckeditor')

		@include('fastadminpanel.pages.not-found')
		@include('fastadminpanel.pages.login')
		@include('fastadminpanel.pages.admin')
		@include('fastadminpanel.pages.admin.parts.sidebar')
		@include('fastadminpanel.pages.admin.pages.cruds.edit')
		@include('fastadminpanel.pages.admin.pages.cruds.entities')
		@include('fastadminpanel.pages.admin.pages.cruds.entity')
		@include('fastadminpanel.pages.admin.pages.cruds.import')
		@include('fastadminpanel.pages.admin.pages.dev.docs')
		@include('fastadminpanel.pages.admin.pages.dev.dropdowns')
		@include('fastadminpanel.pages.admin.pages.dev.settings')
		@include('fastadminpanel.pages.admin.pages.singles.edit')
		@include('fastadminpanel.pages.admin.pages.singles.entity')
		@include('fastadminpanel.pages.admin.pages.singles.fields')
		@include('fastadminpanel.pages.admin.pages.dashboard')
		@include('fastadminpanel.pages.admin.pages.custom')

		@include('fastadminpanel.pages.admin.fields.checkbox')
		@include('fastadminpanel.pages.admin.fields.ckeditor')
		@include('fastadminpanel.pages.admin.fields.color')
		@include('fastadminpanel.pages.admin.fields.date')
		@include('fastadminpanel.pages.admin.fields.datetime')
		@include('fastadminpanel.pages.admin.fields.enum')
		@include('fastadminpanel.pages.admin.fields.file')
		@include('fastadminpanel.pages.admin.fields.gallery')
		@include('fastadminpanel.pages.admin.fields.money')
		@include('fastadminpanel.pages.admin.fields.number')
		@include('fastadminpanel.pages.admin.fields.password')
		@include('fastadminpanel.pages.admin.fields.photo')
		@include('fastadminpanel.pages.admin.fields.relationship')
		@include('fastadminpanel.pages.admin.fields.repeat')
		@include('fastadminpanel.pages.admin.fields.text')
		@include('fastadminpanel.pages.admin.fields.textarea')

		@foreach ($customFields as $customField)
			@include("fastadminpanel.pages.admin.fields.custom.$customField")
		@endforeach

		<script>
			const initStores = async () => {

				const dropdownsStore = useDropdownsStore()
				const crudsStore = useCrudsStore()
				const singlesStore = useSinglesStore()
				const rolesStore = useRolesStore()

				await dropdownsStore.fetchData()
				await crudsStore.fetchData()
				await singlesStore.fetchData()
				await rolesStore.fetchData()
			}

			const checkAuth = async (to, from, next) => {

				const userStore = useUserStore()

				const isAuth = await userStore.isAuth()

				if (isAuth) {
					await initStores()
					next()
				} else {
					next({name: 'login'})
				}
			}

			const routes = [
				{ 
					path: '/admin/login',
					name: 'login',
					component: loginPage,
				},
				{
					path: '/admin',
					component: adminPage,
					beforeEnter: checkAuth,
					children: [
						{
							path: '',
							name: 'home',
							component: dashboardPage,
						},
						{
							path: 'custom',
							name: 'custom',
							component: customPage,
						},
						{
							path: 'dropdowns',
							name: 'dropdowns',
							component: dropdownsPage,
						},
						{
							path: 'settings',
							name: 'settings',
							component: settingsPage,
						},
						{
							path: 'docs',
							name: 'docs',
							component: docsPage,
						},
						{
							path: 'cruds',
							name: 'cruds',
							component: crudsEditPage,
						},
						{
							path: 'cruds/:table',
							name: 'crudsEntities',
							component: crudsEntitiesPage,
						},
						{
							path: 'cruds/:table/import',
							name: 'crudsEntitiesImport',
							component: crudsImportPage,
						},
						{
							path: 'cruds/:table/:id',
							name: 'crudsEntity',
							component: crudsEntityPage,
						},
						{
							path: 'singles',
							name: 'singles',
							component: singlesEditPage,
						},
						{
							path: 'singles/:id',
							name: 'singlesEntity',
							component: singlesEntityPage,
						},
					],
				},
				{ 
					path: '/admin/:pathMatch(.*)*',
					name: 'not-found',
					component: notFoundPage,
				},
			]
		</script>
		
		{{-- TODO: refactor --}}
		@if (!Lang::isMain())
			<script>
				routes.forEach(route => {
					route.path = '/{{Lang::get()}}' + route.path
				})
			</script>
		@endif

		<script>
			const router = VueRouter.createRouter({
				history: VueRouter.createWebHistory(),
				routes,
			})

			const pinia = Pinia.createPinia()

			app.component("v-select", window["vue-select"])

			app.use(pinia)
			app.use(router)
			app.mount('#app')
		</script>
	</body>
</html>