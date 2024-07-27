<script>
const findFieldComponentMixin = {
	methods: {
		findFieldComponent(type, table, name) {

			const components = [
				`field-${type}-${table}-${name}`,
				`field-${type}-all-${name}`,
				`field-${type}-${table}-all`,
				`field-${type}`,
			]

			for (const component of components) {

				if (app.component(component)) {
					return app.component(component)
				}
			}
		},
	},
}
</script>