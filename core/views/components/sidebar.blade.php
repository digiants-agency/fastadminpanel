<script type="text/x-template" id="template-sidebar">
	<div class="sidebar">

		@if(!Platform::mobile())
			<div class="sidebar-header">
				<a href="/" target="_blank">
					<img src="/vendor/fastadminpanel/images/logo.svg" alt="" class="sidebar-logo">
				</a>
				<a href="/admin" class="sidebar-header-title">Admin Panel</a>
			</div>
		@endif

		<div class="sidebar-menu">
			<div class="sidebar-menu-items">
				<router-link to="/admin/dropdown" class="sidebar-menu-item" v-if="is_dev">Dropdown</router-link>
				<router-link to="/admin/options" class="sidebar-menu-item" v-if="is_dev">Options</router-link>

				<template v-for="item in dropdown_menu">
					<div class="sidebar-menu-item-parent" :class="{active: sub_is_active(item.children) || item.active}" v-if="!item.table_name">
						<div class="sidebar-menu-item" v-on:click="item.active = !item.active">
							<img class="sidebar-menu-item-icon" :src="item.icon" alt="" v-if="item.icon">

							<svg v-else class="sidebar-menu-item-icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M14.542 0.655212C14.2572 0.655212 14.0259 0.886176 14.0259 1.17133C14.0259 1.45616 14.2572 1.68745 14.542 1.68745C14.7768 1.68745 14.9678 1.87841 14.9678 2.11293V13.8862C14.9678 14.1207 14.7768 14.3117 14.542 14.3117C14.2572 14.3117 14.0259 14.543 14.0259 14.8278C14.0259 15.113 14.2572 15.3439 14.542 15.3439C15.3458 15.3439 16 14.6901 16 13.8862V2.11293C16 1.30907 15.3458 0.655212 14.542 0.655212ZM12.1501 0.655212C11.8653 0.655212 11.634 0.886176 11.634 1.17133C11.634 1.45616 11.8653 1.68745 12.1501 1.68745C12.3849 1.68745 12.5759 1.87841 12.5759 2.11293V13.8862C12.5759 14.1207 12.3849 14.3117 12.1501 14.3117C11.8653 14.3117 11.634 14.543 11.634 14.8278C11.634 15.113 11.8653 15.3439 12.1501 15.3439C12.9543 15.3439 13.6081 14.6901 13.6081 13.8862V2.11293C13.6081 1.30907 12.9543 0.655212 12.1501 0.655212ZM11.2162 2.11293V13.8862C11.2162 14.6901 10.5624 15.3439 9.75821 15.3439H4.92798C4.6425 15.3439 4.41154 15.1123 4.41186 14.8269C4.41315 14.3662 4.41121 13.4485 4.41121 11.5798C4.41121 11.2227 4.12154 10.9334 3.76478 10.9334C1.8961 10.9334 0.978377 10.9314 0.517418 10.9327C0.23194 10.9331 0.000331199 10.7021 0.000331199 10.4166V2.11293C0.000331199 1.30778 0.652899 0.655212 1.45805 0.655212H9.75821C10.5624 0.655212 11.2162 1.30907 11.2162 2.11293ZM3.91703 11.9437V14.8278C3.91703 15.2786 3.3722 15.5216 3.03576 15.193C-0.0796673 12.0772 0.0511367 12.2574 0.0100084 12.043C-0.0530226 11.7278 0.189521 11.4276 0.51645 11.4276H3.40091C3.68574 11.4276 3.91703 11.6585 3.91703 11.9437Z" fill="#171219"/>
								<clipPath id="clip0_749_34">
								<rect width="16" height="16" fill="white"/>
								</clipPath>
							</svg>

							<span v-text="item.title"></span>

							<span class="sidebar-menu-item-count" v-text="item.count" v-if="item.count != 0"></span>
							
							<div class="sidebar-menu-item-ico-wrapper">
								<svg class="sidebar-menu-item-ico" width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M4.21951 6.06466L7.91359 2.37057C8.0317 2.24828 8.02831 2.0534 7.90601 1.93529C7.78671 1.82007 7.59759 1.82007 7.47831 1.93529L4.00187 5.41173L0.525423 1.93529C0.405221 1.81511 0.210343 1.81511 0.0901413 1.93529C-0.0300427 2.05551 -0.0300427 2.25037 0.0901413 2.37057L3.78422 6.06466C3.90444 6.18484 4.0993 6.18484 4.21951 6.06466Z" fill="#171219"/>
									<clipPath id="clip0_749_96">
										<rect width="8" height="8" fill="white" transform="translate(8) rotate(90)"/>
									</clipPath>
								</svg>
							</div>
						</div>
						<router-link 
							:to="(elm.type == 'multiple') ? '/admin/' + elm.table_name : '/admin/single/' + elm.table_name" 
							:key="elm.id" 
							class="sidebar-menu-item child" 
							:class="{'active': elm.active}" 
							v-if="is_dev || !elm.is_dev" 
							v-for="elm in item.children" 
							v-text="elm.title"
						>
						</router-link>
					</div>
					
					<div class="sidebar-menu-item" :class="{'active': item.active}" v-else-if="is_dev || !item.is_dev">

						<img class="sidebar-menu-item-icon" :src="item.icon" alt="" v-if="item.icon">

						<svg v-else class="sidebar-menu-item-icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M5.81278 0H1.21913C0.547399 0 0.000976562 0.546422 0.000976562 1.21815V5.8118C0.000976562 6.48353 0.547399 7.02995 1.21913 7.02995H5.81278C6.48451 7.02995 7.03093 6.48353 7.03093 5.8118V1.21815C7.03082 0.546422 6.48451 0 5.81278 0Z" fill="#171219"/>
							<path d="M14.7815 0H10.1879C9.51615 0 8.96973 0.546422 8.96973 1.21815V5.8118C8.96973 6.48353 9.51615 7.02995 10.1879 7.02995H14.7815C15.4533 7.02995 15.9997 6.48353 15.9997 5.8118V1.21815C15.9997 0.546422 15.4533 0 14.7815 0Z" fill="#171219"/>
							<path d="M5.8118 8.97003H1.21815C0.546422 8.97003 0 9.5164 0 10.1881V14.7818C0 15.4535 0.546422 15.9999 1.21815 15.9999H5.8118C6.48353 15.9999 7.02995 15.4535 7.02995 14.7818V10.1881C7.02984 9.5164 6.48353 8.97003 5.8118 8.97003Z" fill="#171219"/>
							<path d="M14.7815 8.97003H10.1879C9.51615 8.97003 8.96973 9.51646 8.96973 10.1882V14.7818C8.96973 15.4536 9.51615 16 10.1879 16H14.7815C15.4533 15.9999 15.9997 15.4535 15.9997 14.7818V10.1881C15.9997 9.5164 15.4533 8.97003 14.7815 8.97003Z" fill="#171219"/>
						</svg>

						<router-link :to="(item.type == 'multiple') ? '/admin/' + item.table_name : '/admin/single/' + item.table_name" :key="item.id" v-text="item.title"></router-link>
						
						<span class="sidebar-menu-item-count" v-text="item.count" v-if="item.count != 0"></span>
							
					</div>
				</template>
				<?php foreach ($custom_components as $custom_component): ?>
					<router-link to="/admin/<?php echo $custom_component['name'] ?>" class="sidebar-menu-item"><?php echo mb_convert_case($custom_component['name'], MB_CASE_TITLE) ?></router-link>
				<?php endforeach ?>
			</div>
			
					
			<div class="langs">
				<div class="lang lang-active" v-if="lang.is_active" v-for="lang in languages" v-text="lang.tag"></div>

				<div class="langs-choice">
					<div class="lang" v-if="!lang.is_active" v-for="lang in languages" v-text="lang.tag" v-on:click="set_language(lang)"></div>
				</div>
			</div>
			
			<div class="logout" v-on:click="logout()">
				<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M15.9493 7.07856C15.9153 6.99721 15.8667 6.92321 15.8047 6.86121L13.8053 4.86187C13.5447 4.60187 13.1233 4.60187 12.8627 4.86187C12.602 5.12253 12.602 5.54453 12.8627 5.80453L13.7247 6.66653H10.0006C9.63198 6.66653 9.33398 6.96518 9.33398 7.33318C9.33398 7.70118 9.63198 7.99984 10.0006 7.99984H13.7246L12.8626 8.86184C12.602 9.1225 12.602 9.5445 12.8626 9.8045C12.9926 9.93515 13.1633 9.99984 13.334 9.99984C13.5047 9.99984 13.6753 9.93518 13.8053 9.8045L15.8047 7.80515C15.8667 7.74381 15.9153 7.66981 15.9493 7.58781C16.0166 7.42521 16.0166 7.24121 15.9493 7.07856Z" fill="#7F7F7F"/>
					<path d="M11.3343 9.33334C10.9656 9.33334 10.6676 9.632 10.6676 10V13.3333H8.00098V2.66666C8.00098 2.37266 7.80763 2.11266 7.52563 2.028L5.21029 1.33334H10.6676V4.66669C10.6676 5.03469 10.9656 5.33334 11.3343 5.33334C11.7029 5.33334 12.0009 5.03469 12.0009 4.66669V0.666687C12.0009 0.298656 11.7029 0 11.3343 0H0.667633C0.643633 0 0.622289 0.01 0.598977 0.0126563C0.567633 0.016 0.538977 0.0213125 0.508977 0.0286562C0.438977 0.0466563 0.375633 0.074 0.31632 0.111313C0.301664 0.120656 0.283664 0.121312 0.269664 0.131969C0.264289 0.136 0.262289 0.143344 0.256945 0.147344C0.184289 0.204656 0.123633 0.274656 0.0796328 0.358C0.0702891 0.376 0.0682891 0.395344 0.0609766 0.414C0.0396328 0.464656 0.0163203 0.514 0.00832031 0.57C0.00497656 0.59 0.0109766 0.608656 0.0103203 0.628C0.00966406 0.641344 0.000976562 0.653344 0.000976562 0.666656V14C0.000976562 14.318 0.225633 14.5913 0.536977 14.6533L7.20363 15.9867C7.24698 15.996 7.29098 16 7.33429 16C7.48695 16 7.63695 15.9474 7.75695 15.8487C7.91095 15.722 8.00095 15.5333 8.00095 15.3333V14.6667H11.3343C11.7029 14.6667 12.0009 14.368 12.0009 14V10C12.0009 9.632 11.7029 9.33334 11.3343 9.33334Z" fill="#7F7F7F"/>
					<clipPath id="clip0_749_664">
					<rect width="16" height="16" fill="white"/>
					</clipPath>
				</svg>
				Выйти
			</div>
		</div>
	</div>
</script>
	
<script>
	Vue.component('template-sidebar',{
		template: '#template-sidebar',
		props:['is_dev', 'menu', 'dropdown'],
		data: function () {
			return {
				dropdown_menu: [],
				languages: JSON.parse('<?php echo json_encode($languages); ?>'),
			}
		},
		methods: {
			generate_menu: function(){
				// init
				dropdown_menu = {}
				// set parent
				var last_id = 0
				for (var i = 0; i < this.dropdown.length; i++) {
					dropdown_menu[this.dropdown[i].id] = Object.assign({children: []}, this.dropdown[i])
					last_id = this.dropdown[i].id
				}
				for (var i = this.menu.length - 1; i >= 0; i--) {
					if (this.menu[i].parent != 0) {
						if (dropdown_menu[this.menu[i].parent]) {
							dropdown_menu[this.menu[i].parent].children.push(
								this.menu[i]
							)
						}
					} else {
						last_id++
						dropdown_menu[last_id] = this.menu[i]
					}
				}
				// rm empty dropdown
				for (var i in dropdown_menu) {
					if (!dropdown_menu[i].table_name && dropdown_menu[i].children.length == 0) {
						delete dropdown_menu[i]
					} else if (!dropdown_menu[i].table_name) {
						dropdown_menu[i].active = false
					}
				}
				// sort
				var sortable = [];
				for (var elm in dropdown_menu) {
					sortable.push([elm, dropdown_menu[elm].sort])
				}
				sortable.sort(function(a, b) {
					return a[1] - b[1];
				})

				var sorted = {}
				sortable.forEach(function(item){
					sorted[item[0]] = dropdown_menu[item[0]]
				})
				// save
				this.dropdown_menu = sorted
			},
			sub_is_active: function(input) {
				const paths = Array.isArray(input) ? input : [input]
				return paths.some(path => {
					return this.$route.path.indexOf('/admin/' + path.table_name) === 0
				})
			},
			logout: function() {
				request('/admin/logout');
				this.refresh()
				location.reload()

			},

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
			},

		},
		watch: {
			menu: function(){
				this.generate_menu()
			},
			dropdown: function(){
				this.generate_menu()
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
		},
		mounted: function(){
		},
	})

</script>
