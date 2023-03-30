@extends('fastadminpanel.layouts.app')

@section('content')

@if(Platform::mobile())
	<div class="topbar">
		<div class="toggle" :class="{ active: show_mobile_menu }" @click="show_mobile_menu = !show_mobile_menu">
			<div class="toggle-item"></div>
			<div class="toggle-item"></div>
			<div class="toggle-item"></div>
		</div>
		<div class="sidebar-header">
			<a href="/" target="_blank">
				<img src="/vendor/fastadminpanel/images/logo.svg" alt="" class="sidebar-logo">
			</a>
            <a href="/admin" class="sidebar-header-title">{{ __('fastadminpanel.admin_panel') }}</a>
		</div>
	</div>
@endif

<main>
	<template-sidebar :class="{ active: show_mobile_menu }" :is_dev="is_dev" :menu="menu" :dropdown="dropdown"></template-sidebar>
	<div class="content">
		<router-view></router-view>
	</div>
</main>
@endsection

@section('javascript')
<script>
	const languages = JSON.parse('{!! $languages !!}')
	const ckeditor_path = '<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}"; ?>/admin/upload-image'
</script>

@foreach ($custom_components as $custom_component)
	@include($custom_component['path'])
@endforeach

@include('fastadminpanel.mixins.recursive-field')
@include('fastadminpanel.components.dropdown')
@include('fastadminpanel.components.fields.repeat')
@include('fastadminpanel.components.fields.checkbox')
@include('fastadminpanel.components.fields.ckeditor')
@include('fastadminpanel.components.fields.color')
@include('fastadminpanel.components.fields.date')
@include('fastadminpanel.components.fields.datetime')
@include('fastadminpanel.components.fields.enum')
@include('fastadminpanel.components.fields.file')
@include('fastadminpanel.components.fields.gallery')
@include('fastadminpanel.components.fields.money')
@include('fastadminpanel.components.fields.number')
@include('fastadminpanel.components.fields.password')
@include('fastadminpanel.components.fields.photo')
@include('fastadminpanel.components.fields.relationship')
@include('fastadminpanel.components.fields.text')
@include('fastadminpanel.components.fields.textarea')
@include('fastadminpanel.components.single')
@include('fastadminpanel.components.options')
@include('fastadminpanel.components.sidebar')
@include('fastadminpanel.components.menu')
@include('fastadminpanel.components.edit')
@include('fastadminpanel.components.main')
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
			},{
				path: '/admin',
				name: 'main',
				component: Vue.options.components['template-main'],
			},
		],
	})
	
	Vue.component("v-select", VueSelect.VueSelect);

	var app = new Vue({
		router,
		el: '#app',
		data: {
			is_dev: location.pathname == '/admin/dev',
			menu: [],
			languages: languages,
			dropdown: [],
			show_mobile_menu: false,
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

<script>
	
	$('.sidebar').on('click', function(e) {
        if (this == (e.target)) {
            $(this).removeClass('active')
            $('.toggle').removeClass('active')
        }
    })
	$('.sidebar').on('click', function(e){
		if(e.target.tagName == 'A'){
			$(this).removeClass('active')
			$('.toggle').removeClass('active')
		}
	})
</script>

@endsection