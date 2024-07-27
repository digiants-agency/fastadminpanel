<template id="dashboard">
	<div class="row">
		<div class="blocks-wrapper">
			<h1>Dashboard</h1>
			<div class="blocks">
				<div v-for="statistic in statistics" class="iteminfo">
					<p v-text="statistic.title"></p>
					<span v-text="statistic.count"></span>
				</div>
			</div>
		</div>
		<div class="graphs">
			<div v-for="statistic in statistics" class="graph">
				<canvas :id="'chart-' + statistic.table"></canvas>
			</div>
		</div>
		{{-- <div class="top-sales" v-if="products">
			<h1>Top sales</h1>
			<div class="itemstosale">
				<div v-for="product in products" :key="product.id" class="product">
					<a :href="'/product/' + product.slug" target="_blank">
						<img :src="product.image" alt="">
					</a>
					<a :href="'/product/' + product.slug" class="product-slug" target="_blank" v-text="product.title"></a>
					<div class="product-count" v-text="'Sold: ' + product.count"></div>
				</div>
			</div>
		</div> --}}
	</div>
</template>

<script src="/vendor/fastadminpanel/js/vendor/chart.js"></script>

<script>
const dashboardPage = {
	template: '#dashboard',
	props: [],
	data() {
		return {
			statistics: [],
		}
	},
	mounted() {
		this.fetch()
	},
	methods: {
		async fetch() {
			const response = await req.get("{{ route('admin-api-dashboard-index') }}")
			this.statistics = response.data

			this.$nextTick(()=>{

				for (const statistic of this.statistics) {
	
					const ctx = document.getElementById('chart-' + statistic.table).getContext('2d');
					const chart = new Chart(ctx, {
						type: 'line',
						data: {
							labels: statistic.dates.map(d => d.date),
							datasets: [{
								label: statistic.title,
								data: statistic.dates.map(d => d.count),
								backgroundColor: 'rgba(255, 99, 132, 0.2)',
								borderWidth: 1,
								borderColor: 'rgba(255, 99, 132, 0.2)',
							}]
						},
					})
				}
			})
		},
	},
}
</script>
