<script type="text/x-template" id="template-single">
	<div class="single">
		<div class="single-block" v-for="(block, title) in blocks">
			<div class="single-block-title" v-text="title"></div>
			<div class="single-block-wrapper">
				<div class="single-block-wrapper-block" v-for="(field, field_title) in block">
					<div v-if="field.type != 'repeat'" class="single-block-wrapper-field">
						<template-fields  :field="field"></template-fields>
						<?php if(isset($_GET['dev'])): ?>
							<div class="btn btn-xs btn-danger td-actions-delete mb-3" v-on:click="delete_single(field.id)">Delete</div>
						<?php endif; ?>
					</div>
					<div class="single-repeat" v-else>
						<div class="single-repeat-title" v-text="field.title"></div>
						<div class="single-repeat-group" v-for="(repeat, index) in field.repeat">
							<div class="btn-small btn-danger single-repeat-delete" v-on:click="repeat_rm(field.repeat, index)">
								<svg class="btn-svg" width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M4.88111 4.00017L7.8722 1.00895C7.95447 0.926606 7.99987 0.816752 8 0.699614C8 0.582411 7.9546 0.472427 7.8722 0.390216L7.61008 0.128167C7.52767 0.0456305 7.41782 0.000427246 7.30055 0.000427246C7.18348 0.000427246 7.07363 0.0456305 6.99122 0.128167L4.00013 3.11919L1.00891 0.128167C0.926634 0.0456305 0.816715 0.000427246 0.699512 0.000427246C0.582439 0.000427246 0.47252 0.0456305 0.390244 0.128167L0.128 0.390216C-0.0426667 0.560883 -0.0426667 0.838476 0.128 1.00895L3.11915 4.00017L0.128 6.99126C0.0456585 7.07373 0.000325203 7.18358 0.000325203 7.30072C0.000325203 7.41786 0.0456585 7.52771 0.128 7.61012L0.390179 7.87217C0.472455 7.95464 0.582439 7.99991 0.699447 7.99991C0.81665 7.99991 0.926569 7.95464 1.00885 7.87217L4.00006 4.88108L6.99115 7.87217C7.07356 7.95464 7.18341 7.99991 7.30049 7.99991H7.30062C7.41776 7.99991 7.52761 7.95464 7.61002 7.87217L7.87213 7.61012C7.95441 7.52778 7.9998 7.41786 7.9998 7.30072C7.9998 7.18358 7.95441 7.07373 7.87213 6.99132L4.88111 4.00017Z" fill="white"/>
								</svg>
							</div>
							<div class="btn-blue btn-small single-repeat-move" v-on:click="repeat_move(field.repeat, index)">
								<svg class="btn-svg" width="10" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M5.45962 0.54038C5.20578 0.28654 4.79422 0.28654 4.54038 0.54038L0.403806 4.67696C0.149965 4.9308 0.149965 5.34235 0.403806 5.59619C0.657647 5.85003 1.0692 5.85003 1.32304 5.59619L5 1.91924L8.67696 5.59619C8.9308 5.85003 9.34235 5.85003 9.59619 5.59619C9.85003 5.34235 9.85003 4.9308 9.59619 4.67696L5.45962 0.54038ZM5.65 9L5.65 1L4.35 1L4.35 9L5.65 9Z" fill="#171219"/>
								</svg>
							</div>
							<template-fields :field="f" :key="f.id" v-for="f in repeat"></template-fields>
						</div>

						<div class="btn btn-add btn-dash" v-on:click="repeat_add(field)">Добавить блок +</div>
						
						<?php if(isset($_GET['dev'])): ?>
							<div class="btn btn-xs btn-danger td-actions-delete mb-3" v-on:click="delete_single(field.id)">Delete</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			
		</div>
		<button class="btn btn-primary" v-on:click="save()">Save</button>
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
			delete_single: async function(id){
				if (!confirm('Are you sure?')) {
					return
				}

				const response = await post('/admin/delete-single', {
					id: id,
				})
				
				if (!response.success) {
					alert('Error')
					return
				}
				
				location.reload()
			}
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