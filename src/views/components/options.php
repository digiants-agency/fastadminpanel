<script type="text/x-template" id="template-options">
	<div class="options">
		<div class="btn btn-primary" v-on:click="update_language">Update language</div>
		<div>Add or remove language you can directly in your DB</div>
	</div>
</script>

<script>
	Vue.component('template-options',{
		template: '#template-options',
		props: [],
		data: function () {
			return {

			}
		},
		methods: {
			update_language: function(){
				request('/admin/update-languages', {}, function(data){
					if (data == 'Success') document.location.reload()
					else alert('Error: ' + data)
				})
			},
		},
		mounted: function(){
			
		}
	})
</script>