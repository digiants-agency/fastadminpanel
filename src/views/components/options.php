<script type="text/x-template" id="template-options">
	<div class="options">
		<div class="btn btn-primary" v-on:click="rm_language">Delete language</div>
		<div class="btn btn-primary" v-on:click="add_language">Add language</div>
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
			rm_language: function(){

				var lang_tag = prompt('Enter language', '')
				
				if (lang_tag) {

					request('/admin/remove-language/' + lang_tag, {}, function(data){
						if (data == 'Success') document.location.reload()
						else alert('Error: ' + data)
					})
				}
			},
			add_language: function(){

				var lang_tag = prompt('Enter language', '')
				
				if (lang_tag) {
					request('/admin/add-language/' + lang_tag, {}, function(data){
						if (data == 'Success') document.location.reload()
						else alert('Error: ' + data)
					})
				}
			},
		},
		mounted: function(){
			
		}
	})
</script>