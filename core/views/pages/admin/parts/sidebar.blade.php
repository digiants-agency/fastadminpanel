<template id="sidebar">
	<div class="sidebar">

		@if(!Platform::mobile())
			<div class="sidebar-header">
				<a href="/" target="_blank">
					<img src="/vendor/fastadminpanel/images/logo.svg" alt="" class="sidebar-logo">
				</a>
				<router-link :to="{name: 'home'}" class="sidebar-header-title">
					{{ __('fastadminpanel.admin_panel') }}
				</router-link>
			</div>
		@endif

		<div class="sidebar-menu">
			<div class="sidebar-menu-items">
				<div class="sidebar-menu-items-dev" v-if="menuStore.isDev">
					<div class="sidebar-menu-item">
						<img src="/vendor/fastadminpanel/images/options.svg" alt="" class="sidebar-menu-item-icon">
						<router-link :to="{name: 'cruds'}">{{ __('fastadminpanel.crud') }}</router-link>
					</div>
					<div class="sidebar-menu-item">
						<img src="/vendor/fastadminpanel/images/options.svg" alt="" class="sidebar-menu-item-icon">
						<router-link :to="{name: 'singles'}">{{ __('fastadminpanel.single') }}</router-link>
					</div>
					<div class="sidebar-menu-item">
						<img src="/vendor/fastadminpanel/images/options.svg" alt="" class="sidebar-menu-item-icon">
						<router-link :to="{name: 'dropdowns'}">{{ __('fastadminpanel.dropdown') }}</router-link>
					</div>
					<div class="sidebar-menu-item">
						<img src="/vendor/fastadminpanel/images/options.svg" alt="" class="sidebar-menu-item-icon">
						<router-link :to="{name: 'settings'}">{{ __('fastadminpanel.settings') }}</router-link>
					</div>
					<div class="sidebar-menu-item">
						<img src="/vendor/fastadminpanel/images/options.svg" alt="" class="sidebar-menu-item-icon">
						<router-link :to="{name: 'docs'}">{{ __('fastadminpanel.docs') }}</router-link>
					</div>
				</div>
				<template v-for="item in menuStore.menu">
					<div v-if="item.type == 'dropdown'" class="sidebar-menu-item-parent" :class="{active: item.isActive}">
						<div class="sidebar-menu-item" v-on:click="menuStore.toggleDropdown(item.id)">
							<img v-if="item.icon" class="sidebar-menu-item-icon" :src="item.icon" alt="">
							<img v-else class="sidebar-menu-item-icon" src="/vendor/fastadminpanel/images/paper.svg" alt="" class="sidebar-menu-item-icon">
							<span v-text="item.title"></span>
							<span v-if="item.count != 0" class="sidebar-menu-item-count" v-text="item.count"></span>
							<div class="sidebar-menu-item-ico-wrapper">
								<img class="sidebar-menu-item-ico" src="/vendor/fastadminpanel/images/dropdown-ico.svg" alt="" class="sidebar-menu-item-icon">
							</div>
						</div>
						<router-link 
							v-for="btn in item.children"
							v-show="btn.isActive"
							:key="btn.id"
							:to="btn.link"
							class="sidebar-menu-item child"
							{{-- :class="{'active': btn.active}" --}}
							v-text="btn.title"
						>
						</router-link>
					</div>
					<div v-else-if="item.isActive" class="sidebar-menu-item" {{-- :class="{'active': item.active}" --}}>
						<img class="sidebar-menu-item-icon" :src="item.icon" alt="" v-if="item.icon">
						<img v-else src="/vendor/fastadminpanel/images/squares.svg" alt="" class="sidebar-menu-item-icon">
						<router-link :to="item.link" :key="item.id" v-text="item.title"></router-link>
						<span v-if="item.count != 0" class="sidebar-menu-item-count" v-text="item.count"></span>
					</div>
				</template>
			</div>
			<div class="sidebar-bottom">
				<div class="langs">
					<div class="lang lang-active" :class="{'with-arrow' : languageStore.count > 1}" v-text="languageStore.tag"></div>
					<div class="langs-choice">
						<div class="lang" v-show="lang.tag != languageStore.tag" v-for="lang in languageStore.all" v-text="lang.tag" v-on:click="languageStore.set(lang.tag)"></div>
					</div>
				</div>
				<div class="logout" v-on:click="userStore.signOut()">
					<img src="/vendor/fastadminpanel/images/logout.svg" alt="" class="logout-ico">
					{{ __('fastadminpanel.sign_out') }}
				</div>
			</div>
		</div>
	</div>
</template>
	
<script>
app.component('sidebar', {
	template: '#sidebar',
	props: [],
	data() {
		return {
		}
	},
	computed: {
		...Pinia.mapStores(useLanguageStore, useUserStore, useMenuStore)
	},
	watch: {
	},
	created() {
	},
	mounted() {
	},
	methods: {
	},
})
</script>
