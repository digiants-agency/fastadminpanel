<template id="single-entity">
	<div class="single">
		<div v-for="block in blocks">
			<h1 v-text="block.title"></h1>
			<div class="field-repeat-values">
				<component
					v-for="field in block.fields"
					:is="'field-' + field.type"
					:field="field"
					:key="field.id"
				></component>
			</div>
		</div>
		<button v-if="singlesStore.canEdit($route.params.id)" class="btn btn-primary" v-on:click="save()">{{ __('fastadminpanel.save') }}</button>
	</div>
</template>

<script>
const singlesEntityPage = {
	template: '#single-entity',
	props: [],
	data() {
		return {
			blocks: [],
		}
	},
	computed: {
		...Pinia.mapStores(useSinglesStore),
	},
	watch: {
		'$route.params.id'() {
			this.fetch()
		},
	},
	created() {
		this.fetch()
	},
	mounted() {
	},
	methods: {
		async save() {

			// TODO: recursive check every field by method "check"
			// TODO: recursive map for blocks to reduce size of request
			const route = "{{ route('admin-api-singles-values-update', ['single_page' => 'single_page'], false) }}"
				.replace('single_page', this.$route.params.id)

			const response = await req.put(route, {
				blocks: this.blocks,
			})
		},
		async fetch() {

			const route = "{{ route('admin-api-singles-values-show', ['single_page' => 'single_page'], false) }}"
				.replace('single_page', this.$route.params.id)

			const response = await req.get(route)

			this.blocks = response.data
		},
	},
}
</script>