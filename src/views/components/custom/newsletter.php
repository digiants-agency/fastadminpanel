<script type="text/x-template" id="template-newsletter">
	<div class="newsletter">
		<ul class="nav nav-tabs">
			<li class="nav-item">
				<div class="nav-link" :class="{active: tab == 'statistics'}" v-on:click="tab = 'statistics'">Statistics</div>
			</li>
			<li class="nav-item">
				<div class="nav-link" :class="{active: tab == 'most-active'}" v-on:click="tab = 'most-active'">The most active</div>
			</li>
			<li class="nav-item">
				<div class="nav-link" :class="{active: tab == 'mailing'}" v-on:click="tab = 'mailing'">Mailing</div>
			</li>
			<li class="nav-item">
				<div class="nav-link" :class="{active: tab == 'letter'}" v-on:click="tab = 'letter'">Letters</div>
			</li>
			<li class="nav-item">
				<div class="nav-link" :class="{active: tab == 'base'}" v-on:click="tab = 'base'">Base</div>
			</li>
		</ul>
		<div class="newsletter-content">
			<div class="newsletter-statistics" v-if="tab == 'statistics'">
				<h2>Statistics:</h2>
				<div class="newsletter-statistics-line" v-for="statistic in statistics">
					<span v-text="statistic.title"></span>: <span v-text="statistic.value"></span>
				</div>
			</div>
			<div class="newsletter-most-active" v-else-if="tab == 'most-active'">
				<h2>The most active clients:</h2>
				<div class="newsletter-statistics-line" v-for="client in most_active">
					<span v-text="client.email"></span> - <span v-text="client.hits"></span> hits
				</div>
			</div>
			<div class="newsletter-mailing" v-else-if="tab == 'mailing'">
				<template-mailing :letters="letters" :bases="bases" :queue="queue"></template-mailing>
			</div>
			<div class="newsletter-letter" v-else-if="tab == 'letter'">
				<template-letter :letters="letters"></template-letter>
			</div>
			<div class="newsletter-base" v-else-if="tab == 'base'">
				<template-base :bases="bases"></template-base>
			</div>
		</div>
	</div>
</script>

<script>
	Vue.component('vue-prism-editor', VuePrismEditor)
	Vue.component('template-newsletter',{
		template: '#template-newsletter',
		data: function () {
			return {
				tab: 'statistics',
				statistics: [],
				most_active: [],
				bases: [],
				letters: [],
				queue: 0,
			}
		},
		methods: {
		},
		watch: {
		},
		created: function(){
			request('/admin/newsletter/get', {}, (data)=>{
				this.statistics = data.statistics
				this.most_active = data.most_active
				this.bases = data.bases
				this.letters = data.letters
				this.queue = data.queue
			})
		},
		beforeDestroy: function(){
		},
	})
</script>

<script type="text/x-template" id="template-base">
	<div>
		<table class="table newsletter-base">
			<tr>
				<th>Subject</th>
				<th>Date</th>
				<th>Actions</th>
			</tr>
			<tr v-for="base in bases">
				<td v-text="base.title"></td>
				<td v-text="base.date"></td>
				<td>
					<div class="btn btn-primary" v-on:click="download(base)">Download</div>
					<div class="btn btn-danger" v-on:click="rm(base)">Delete</div>
				</td>
			</tr>
		</table>
		<div class="newsletter-letter-new">
			<input type="file" class="form-control newsletter-letter-field" v-on:change="change_file">
			<input type="date" class="form-control newsletter-letter-field" v-model="new_add.date">
			<input type="text" class="form-control newsletter-letter-field" v-model="new_add.title" placeholder="Title">
			<div class="btn btn-primary" v-on:click="add()">Add</div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-base',{
		template: '#template-base',
		props: ['bases'],
		data: function () {
			return {
				new_add: {
					file: null,
					date: null,
					title: '',
				},
			}
		},
		methods: {
			change_file: function($event){
				if ($event.target.files.length > 0) {
					this.new_add.file = $event.target.files[0]
				} else {
					this.new_add.file = null
				}
			},
			download: function(base){
				
				var pass = prompt('Password', '')

				if (pass) {
					request('/admin/newsletter/base/download', {
						id: base.id,
						password: pass,
					}, (data)=>{
						
						var link = document.createElement('a')
						link.setAttribute('href', data)
						link.setAttribute('download', 'export.xlsx')
						link.click()

					}, (data)=>{
						alert(data.responseText)
					})
				}
			},
			rm: function(base){
				if (confirm('Are you sure?')) {
					request('/admin/newsletter/base/rm', {
						id: base.id,
					}, (data)=>{
						this.$parent.bases = data
					}, (data)=>{
						alert(data.responseText)
					})
				}
			},
			add: function(){

				if (this.new_add.title == '' || this.new_add.date == null || this.new_add.title == null)
					return

				var form_data = new FormData()

				form_data.append('file', this.new_add.file)
				form_data.append('date', this.new_add.date)
				form_data.append('title', this.new_add.title)

				request_file('/admin/newsletter/base/add', form_data, (data)=>{
					this.$parent.bases = data
				}, (data)=>{
					alert(data.responseText)
				})
			},
		},
	})
</script>

<script type="text/x-template" id="template-letter">
	<div>
		<table class="table newsletter-letters">
			<tr>
				<th>Subject</th>
				<th>Date</th>
				<th>Actions</th>
			</tr>
			<tr v-for="letter in letters" :class="{'newsletter-row-highlight': curr.id == letter.id}">
				<td v-text="letter.subject"></td>
				<td v-text="letter.date"></td>
				<td>
					<div class="btn btn-primary" v-on:click="edit_letter(letter)">Select</div>
					<div class="btn btn-danger" v-on:click="rm_letter(letter)">Delete</div>
					<div class="btn btn-primary" v-if="curr.id == letter.id" v-on:click="save_letter(letter)">Save</div>
				</td>
			</tr>
		</table>
		<div class="newsletter-letter-new">
			<input type="date" class="form-control newsletter-letter-field" v-model="new_date">
			<input type="text" class="form-control newsletter-letter-field" v-model="new_subject" placeholder="New subject">
			<div class="btn btn-primary" v-on:click="add_letter()">Add</div>
		</div>
		<div v-show="curr.id">
			<div class="newsletter-code">
				<vue-prism-editor v-model="editor" :lineNumbers="true" language="html"></vue-prism-editor>
			</div>
			<iframe src="" class="newsletter-html" frameborder="0" ref="iframe"></iframe>
		</div>
	</div>
</script>
<script>
	Vue.component('template-letter',{
		template: '#template-letter',
		props: ['letters'],
		data: function () {
			return {
				new_subject: '',
				new_date: new Date(),
				curr: {},
				editor: '',
			}
		},
		methods: {
			save_letter: function(letter){

				if (!confirm('Are you sure?'))
					return

				letter.template = this.editor

				request('/admin/newsletter/letter/save', {
					letter: letter,
				}, (data)=>{
					// this.$parent.letters = data
				})
			},
			edit_letter: function(letter){
				this.curr = letter
				this.editor = letter.template
			},
			rm_letter: function(letter){

				if (!confirm('Are you sure?'))
					return

				request('/admin/newsletter/letter/rm', {
					id: letter.id,
				}, (data)=>{
					this.curr = {}
					this.$parent.letters = data
				})
			},
			add_letter: function(){

				request('/admin/newsletter/letter/add', {
					subject: this.new_subject,
					date: this.new_date,
				}, (data)=>{
					this.$parent.letters = data
				})
			},
		},
		watch: {
			editor: function(val){
				var iframe_doc = this.$refs.iframe.contentWindow.document
				iframe_doc.open()
				iframe_doc.write(val)
				iframe_doc.close()
				this.$refs.iframe.style.height = (this.$refs.iframe.contentWindow.document.documentElement.offsetHeight + 4) + 'px'
			},
		},
	})
</script>

<script type="text/x-template" id="template-mailing">
	<div class="row">
		<div class="col-md-6">
			<h2>Choose base:</h2>
			<table class="table">
				<tr>
					<th>Title</th>
					<th>Date</th>
					<th></th>
				</tr>
				<tr v-for="base in bases">
					<td v-text="base.title"></td>
					<td v-text="base.date"></td>
					<td>
						<input type="checkbox" v-model="base.is_mark">
					</td>
				</tr>
			</table>
		</div>
		<div class="col-md-6">
			<h2>Choose letter:</h2>
			<select class="form-control" v-model="letter">
				<option value="0">None</option>
				<option :value="letter.id" v-for="letter in letters" v-text="letter.subject"></option>
			</select>
		</div>
		<div class="col-md-12 newsletter-sending-now">
			<strong>Current queue: <span v-text="queue"></span></strong>
		</div>
		<div class="col-md-12">
			<div class="btn btn-primary" v-on:click="add_queue()">Send</div>
			<div class="btn btn-danger" v-on:click="rm_queue()">Clear queue</div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-mailing',{
		template: '#template-mailing',
		props: ['bases', 'letters', 'queue'],
		data: function () {
			return {
				letter: 0,
			}
		},
		methods: {
			add_queue: function(){

				var ids = []
				for (var i = this.bases.length - 1; i >= 0; i--) {
					if (this.bases[i].is_mark)
						ids.push(this.bases[i].id)
				}

				if (ids.length < 1) {
					alert('Choose at least one base')
					return
				}

				if (this.letter == 0) {
					alert('Choose letter')
					return
				}

				if (confirm('Are you sure?')) {

					request('/admin/newsletter/add', {
						ids: ids,
						letter: this.letter,
					}, (data)=>{
						this.$parent.queue = data
					})
				}
			},
			rm_queue: function(){
				if (confirm('Are you sure?')) {

					request('/admin/newsletter/rm', {}, (data)=>{
						this.$parent.queue = data
					})
				}
			},
		},
	})
</script>

<style>
	.newsletter-row-highlight {
		background-color: #d0ffd0;
	}
	.newsletter-code {
		max-height: 300px;
		overflow: auto;
	}
	.newsletter .nav-link {
		cursor: pointer;
	}
	.newsletter-content {
		padding: 15px;
		border: 1px solid #dee2e6;
		border-top: 0;
	}
	.newsletter-content h2 {
		margin-bottom: 15px;
	}
	.newsletter-sending-now {
		margin-bottom: 15px;
	}
	.newsletter-html {
		margin: 20px 0;
		border: 1px solid #dee2e6;
		width: 100%;
	}
	.newsletter-letter-new {
		display: flex;
		margin-bottom: 30px;
	}
	.newsletter-letter-field {
		width: 200px;
		margin-right: 15px;
	}
	.newsletter td {
		vertical-align: middle;
	}
</style>