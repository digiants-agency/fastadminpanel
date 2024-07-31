<template id="custom">
	<div class="index">
		<h1>Custom page</h1>
		<div class="index-body">
			<div class="btn btn-primary" v-on:click="fetchData">
				Do something
			</div>
		</div>
	</div>
</template>

<script src="/vendor/fastadminpanel/js/vendor/chart.js"></script>

<script>
const customPage = {
	template: '#custom',
	props: [],
	data() {
		return {
			// 
		}
	},
	computed: {
		// ...Pinia.mapStores(useLanguageStore, useUserStore, useMenuStore)
	},
	watch: {
	},
	created() {
		// this.fetchData()
	},
	mounted() {
	},
	methods: {
		fetchData() {

			const response = req.post('/url-here', {
				param1: 'test',
			})

			if (response.success) {

				// 
			}
		}
	},
}
</script>
