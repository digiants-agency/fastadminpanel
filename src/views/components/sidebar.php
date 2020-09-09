<script type="text/x-template" id="template-sidebar">
	<div class="sidebar">
		<div class="sidebar-menu">
			<router-link to="/admin/dropdown" class="sidebar-menu-item" v-if="is_dev">Dropdown</router-link>
			<router-link to="/admin/options" class="sidebar-menu-item" v-if="is_dev">Options</router-link>
			<!-- <template v-for="item in menu">
				<router-link :to="(item.type == 'multiple') ? '/admin/' + item.table_name : '/admin/single/' + item.table_name" :key="item.id" class="sidebar-menu-item" :class="{'active': item.active}" v-if="is_dev || !item.is_dev" v-text="item.title"></router-link>
			</template> -->
			<template v-for="item in dropdown_menu">
				<div class="sidebar-menu-item-parent" :class="{active: sub_is_active(item.children) || item.active}" v-if="!item.table_name">
					<div class="sidebar-menu-item" v-on:click="item.active = !item.active">
						<span v-text="item.title"></span>
						<svg class="sidebar-menu-item-ico" width="292.359px" height="292.359px" viewBox="0 0 292.359 292.359">
							<path d="M222.979,133.331L95.073,5.424C91.456,1.807,87.178,0,82.226,0c-4.952,0-9.233,1.807-12.85,5.424
								c-3.617,3.617-5.424,7.898-5.424,12.847v255.813c0,4.948,1.807,9.232,5.424,12.847c3.621,3.617,7.902,5.428,12.85,5.428
								c4.949,0,9.23-1.811,12.847-5.428l127.906-127.907c3.614-3.613,5.428-7.897,5.428-12.847
								C228.407,141.229,226.594,136.948,222.979,133.331z"/>
						</svg>
					</div>
					<router-link :to="(elm.type == 'multiple') ? '/admin/' + elm.table_name : '/admin/single/' + elm.table_name" :key="elm.id" class="sidebar-menu-item child" :class="{'active': elm.active}" v-if="is_dev || !elm.is_dev" v-for="elm in item.children" v-text="elm.title"></router-link>
				</div>
				<router-link :to="(item.type == 'multiple') ? '/admin/' + item.table_name : '/admin/single/' + item.table_name" :key="item.id" class="sidebar-menu-item" :class="{'active': item.active}" v-else-if="is_dev || !item.is_dev" v-text="item.title"></router-link>
			</template>
			<?php foreach ($custom_components as $custom_component): ?>
				<router-link to="/admin/<?php echo $custom_component['name'] ?>" class="sidebar-menu-item"><?php echo mb_convert_case($custom_component['name'], MB_CASE_TITLE) ?></router-link>
			<?php endforeach ?>
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
			}
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
		},
		mounted: function(){
		},
	})
</script>