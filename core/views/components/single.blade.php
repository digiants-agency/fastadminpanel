<template id="template-single">
	<div class="single">

		<div v-for="(fields, title) in blocks">
			<h1 v-text="title"></h1>
			<div class="field-repeat-values">
				<component :is="'template-field-' + field.type" :field="field" v-for="field in fields"></component>					
			</div>
		</div>

		<button class="btn btn-primary" v-on:click="save()">{{ __('fastadminpanel.save') }}</button>
	</div>
</template>

<script>
	Vue.component('template-single', {
		template: '#template-single',
		props: [],
		data() {
			return {
				blocks: [],
				errors: {},
			}
		},
		methods: {
			async save() {

				// TODO: recursive check every field by method "check"
				// TODO: recursive map for blocks to reduce size of request
				const response = await req.put('/admin/api/single/' + this.$route.params.single_id, {
					blocks: this.blocks,
				})
			},
			async init() {

				const response = await req.get('/admin/api/single/' + this.$route.params.single_id)

				this.blocks = response.data
			},
			repeat_move(fields, index) {

				if (index > 0) {
					var temp = fields[index]
					fields[index] = fields[index - 1]
					fields[index - 1] = temp
					this.$forceUpdate()
				}
			},
			repeat_rm(fields, index) {

				if (confirm('Are you sure?')) {
					fields.splice(index, 1)
					this.$forceUpdate()
				}
			},
			repeat_add(field) {

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
			async delete_single(id) {
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
			'$route.params.single_id'() {
				this.init()
			},
		},
		created() {

			this.init()
		},
	})
</script>