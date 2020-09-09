<script type="text/x-template" id="template-single">
	<div class="single">
		<div class="single-block" v-for="(block, title) in blocks">
			<div class="single-block-title" v-text="title"></div>
			<div v-for="(field, field_title) in block">
				<template-fields v-if="field.type != 'repeat'" :field="field"></template-fields>
				<div class="single-repeat" v-else>
					<div class="single-repeat-title" v-text="field.title"></div>
					<div class="single-repeat-group" v-for="(repeat, index) in field.repeat">
						<div class="single-repeat-delete" v-on:click="repeat_rm(field.repeat, index)">-</div>
						<div class="single-repeat-move" v-on:click="repeat_move(field.repeat, index)">↑</div>
						<template-fields :field="f" :key="f.id" v-for="f in repeat"></template-fields>
					</div>
					<div class="single-repeat-btns">
						<div class="btn btn-xs btn-info" v-on:click="repeat_add(field)">Add</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row form-group single-btns">
			<label class="col-sm-2 control-label"></label>
			<div class="col-sm-10">
				<button class="btn btn-primary" v-on:click="save()">Save</button>
			</div>
		</div>
	</div>
</script>

<script>
	Vue.component('template-single',{
		template: '#template-single',
		props:[],
		data: function () {
			return {
				blocks: [],
				errors: {},
			}
		},
		methods: {
			save: function(){
				request('/admin/set-single/' + this.$route.params.single_id, {
					blocks: this.blocks,
				}, (data)=>{
					
				}, (data)=>{
					alert('Error')
				})
			},
			init: function(){
				request('/admin/get-single/' + this.$route.params.single_id, {}, (data)=>{
					this.blocks = data
				})
			},
			repeat_move: function(fields, index){
				if (index > 0) {
					var temp = fields[index]
					fields[index] = fields[index - 1]
					fields[index - 1] = temp
					this.$forceUpdate()
				}
			},
			repeat_rm: function(fields, index){
				if (confirm('Are you sure?')) {
					fields.splice(index, 1)
					this.$forceUpdate()
				}
			},
			repeat_add: function(field){

				if (!field.repeat)
					field.repeat = []

				field.repeat.push([])

				var last = field.repeat[field.repeat.length - 1]

				for (var i = 0, length = field.value.length; i < length; i++) {
					
					last.push({
						id: i,
						title: field.value[i].title,
						type: field.value[i].type,
						value: '',
					})
				}
				
				this.$forceUpdate()
			},
		},
		watch: {
			'$route.params.single_id': function(){
				this.init()
			},
		},
		created: function(){
			this.init()
		},
	})
</script>