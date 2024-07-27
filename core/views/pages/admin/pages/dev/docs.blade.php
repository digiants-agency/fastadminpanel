<template id="docs">
	<div class="flex">
		<div class="docs-routes">
			<div v-for="(endpointGroup, index) in docs" class="docs-routes-block">
				<a :href="'#' + index" class="edit-field-title docs-group-title" v-text="index"></a>
				<a :href="'#' + endpoint.method + '-' + endpoint.endpoint" v-for="endpoint in endpointGroup" class="edit-field-title docs-routes-endpoint">
					<span v-text="endpoint.method" class="docs-route-method" :class="{
						'docs-route-get' : endpoint.method == 'GET',
						'docs-route-post' : endpoint.method == 'POST',
						'docs-route-put' : endpoint.method == 'PUT',
						'docs-route-delete' : endpoint.method == 'DELETE',
						}"
					></span> 
					<span v-text="endpoint.endpoint" class="docs-routes-endpoint-text"></span>
				</a>
			</div>
		</div>
		<div class="docs-content">
			<h1>API {{ __('fastadminpanel.docs') }}</h1>
			@if (Lang::count() > 1)
				<div class="docs-routes-endpoint-desc">
					This website is multi-lingual. 
					The route "/fapi/example" have main language ({{Lang::main()}}). 
					To get this route with "{{Lang::all()->first(fn ($l) => $l->main_lang == 0)->tag}}" language, 
					add prefix: "/{{Lang::all()->first(fn ($l) => $l->main_lang == 0)->tag}}/fapi/example".
				</div>
			@endif
			<div v-for="(endpointGroup, index) in docs" class="docs-block" :id="index">
				<h1 v-text="index"></h1>
				<div :id="endpoint.method + '-' + endpoint.endpoint" v-for="endpoint in endpointGroup" class="docs-routes-endpoint-block">
					<div class="edit-field-title docs-routes-endpoint">
						<span v-text="endpoint.method" class="docs-route-method" :class="{
							'docs-route-get' : endpoint.method == 'GET',
							'docs-route-post' : endpoint.method == 'POST',
							'docs-route-put' : endpoint.method == 'PUT',
							'docs-route-delete' : endpoint.method == 'DELETE',
							}"
						></span> 
						<span v-text="endpoint.endpoint" class="docs-routes-endpoint-text"></span>
					</div>
					<div class="docs-routes-endpoint-desc" v-text="endpoint.description"></div>
					<div class="docs-routes-endpoint-desc-block">
						<div class="docs-routes-endpoint-desc-block-title">REQUEST SCHEMA</div>
						<div class="docs-routes-endpoint-desc-block-value">application/json</div>
					</div>
					<div v-if="getParams(endpoint.endpoint).length" class="docs-routes-endpoint-desc-block">
						<div class="docs-routes-endpoint-desc-block-title">PATH PARAMETERS</div>
						<div class="docs-routes-endpoint-desc-block-value">
							<div v-for="param in getParams(endpoint.endpoint)" class="docs-route-rule">
								<div class="docs-route-rule-title-wrapper">
									<div class="docs-route-rule-title">
										<span class="text-blue-500">¬</span>
										<span v-text="param[1]"></span>
									</div>
									<div class="docs-route-rule-required required">required</div>
								</div>
								<div class="docs-route-rule-description-wrapper">
									<div class="docs-route-rule-description">
										String
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="docs-routes-endpoint-desc-block" v-if="endpoint.method == 'GET' || endpoint.method == 'POST' || endpoint.method == 'PUT'">
						<div class="docs-routes-endpoint-desc-block-title" v-if="endpoint.method == 'GET'">QUERY PARAMETERS</div>
						<div class="docs-routes-endpoint-desc-block-title" v-else-if="endpoint.method == 'POST' || endpoint.method == 'PUT'">REQUEST BODY PARAMETERS</div>
						<div class="docs-routes-endpoint-desc-block-value">
							<div class="docs-route-rule" v-for="field in endpoint.fields">
								<div class="docs-route-rule-title-wrapper">
									<div class="docs-route-rule-title">
										<span class="text-blue-500">¬</span>
										<span v-text="field.title"></span>
									</div>
									<div class="docs-route-rule-required" :class="{'required' : field.required == 'required', 'optional' : field.required == 'nullable'}" v-text="field.required == 'required' ? 'required' : 'optional'"></div>
								</div>
								<div class="docs-route-rule-description-wrapper">
									<div class="docs-route-rule-description" v-text="field.type"></div>
									<div class="docs-route-rule-available" v-if="field.desc" v-text="field.desc"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
const docsPage = {
	template: '#docs',
	props: [],
	data() {
		return {
			docs: [],
		}
	},
	async created() {

		const response = await req.get("{{ route('admin-api-docs-index', [], false) }}")
		this.docs = response.data.docs
	},
	methods: {
		getParams(url) {
			return [...url.matchAll(/\{([a-z]+)\}/g)] 
		},
	},
}
</script>