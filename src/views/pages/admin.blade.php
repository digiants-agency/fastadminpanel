@extends('fastadminpanel.layouts.app')

@section('content')
<div class="topbar">
	<div>Admin panel</div>
	<div class="langs">
		<div class="langs-elm" :class="{'active': lang.is_active}" v-for="lang in languages" v-text="lang.tag" v-on:click="set_language(lang)"></div>
	</div>
</div>
<main>
	<template-sidebar :is_dev="is_dev" :menu="menu" :dropdown="dropdown"></template-sidebar>
	<div class="content">
		<router-view></router-view>
	</div>
</main>
@endsection

@section('javascript')
<script>
	var languages = JSON.parse('{!! $languages !!}')
	var ckeditor_path = '<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}"; ?>/admin/upload-image'
</script>
@foreach ($custom_components as $custom_component)
	@include($custom_component['path'])
@endforeach
@include('fastadminpanel.components.dropdown')
@include('fastadminpanel.components.fields-dynamic')
@include('fastadminpanel.components.fields')
@include('fastadminpanel.components.single')
@include('fastadminpanel.components.options')
@include('fastadminpanel.components.sidebar')
@include('fastadminpanel.components.menu')
@include('fastadminpanel.components.edit')
@include('fastadminpanel.components.index')
<script>
	const router = new VueRouter({
		mode: 'history',
		routes: [
			<?php foreach ($custom_components as $custom_component): ?>
			{
				path: '/admin/<?php echo $custom_component['name'] ?>',
				name: '<?php echo $custom_component['name'] ?>',
				component: Vue.options.components['template-<?php echo $custom_component['name'] ?>'],
			},
			<?php endforeach ?>
			{
				path: '/admin/dropdown',
				name: 'dropdown',
				component: Vue.options.components['template-dropdown'],
			}, {
				path: '/admin/single/:single_id',
				name: 'single',
				component: Vue.options.components['template-single'],
			}, {
				path: '/admin/menu',
				name: 'menu',
				component: Vue.options.components['template-menu'],
			}, {
				path: '/admin/options',
				name: 'options',
				component: Vue.options.components['template-options'],
			}, {
				path: '/admin/:table_name',
				name: 'index',
				component: Vue.options.components['template-index'],
			}, {
				path: '/admin/:table_name/create',
				name: 'create',
				component: Vue.options.components['template-edit'],
			}, {
				path: '/admin/:table_name/edit/:edit_id',
				name: 'edit',
				component: Vue.options.components['template-edit'],
			},
		],
	})

	var app = new Vue({
		router,
		el: '#app',
		data: {
			is_dev: location.pathname == '/admin/dev',
			menu: [],
			languages: languages,
			dropdown: [],
		},
		methods: {
			get_language: function(){
				for (i in this.languages) {
					if (this.languages[i].is_active)
						return this.languages[i]
				}
				return null
			},
			set_language: function(lang){

				set_cookie('lang', lang.tag, 30)
				document.location.reload()

				// for (i in this.languages) {
				// 	if (this.languages[i].id == lang.id) {

				// 		this.languages[i].is_active = true
				// 		// this.$root.$emit('set_language', lang)
				// 		set_cookie('lang', lang.tag, 30)

				// 	} else this.languages[i].is_active = false
				// }
				// this.$forceUpdate()
			},
		},
		created: function(){

			var lang_tag = get_cookie('lang')

			if (!lang_tag) {
				for (i in this.languages) {
					if (this.languages[i].main_lang == 1) {

						this.languages[i].is_active = true
						set_cookie('lang', this.languages[i].tag, 30)

					} else this.languages[i].is_active = false
				}
			} else {
				for (i in this.languages) {
					if (this.languages[i].tag == lang_tag) {

						this.languages[i].is_active = true
						set_cookie('lang', this.languages[i].tag, 30)

					} else this.languages[i].is_active = false
				}
			}
			
			request('/admin/get-menu', {}, (data)=>{
				
				this.menu = data.menu
				this.dropdown = data.dropdown

				this.$root.$emit('menu_init', this.menu)
			})
		},
		mounted: function(){

		},
	})
</script>
@endsection