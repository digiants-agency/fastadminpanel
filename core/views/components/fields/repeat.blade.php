<template id="template-field-repeat">
	<div class="field-repeat">
		<h1 v-text="field.title"></h1>
		<div class="field-repeat-groups">
			<template v-for="i in length">
				<div class="field-repeat-values">
					<div class="btn btn-danger btn-small field-repeat-btn" v-on:click="remove(pointer, field.value, i - 1, false)">
						<img src="/vendor/fastadminpanel/images/close.svg" alt="" class="btn-svg">
					</div>
					<component
						:is="'template-field-' + subfield.type"
						:field="subfield"
						:pointer="[...(pointer ?? []), i - 1]"
						:key="subfield.id"
						v-for="subfield in field.value.fields">
					</component>
				</div>
			</template>
			<div class="btn btn-add" v-on:click="add">{{ __('fastadminpanel.add_field') }} +</div>
		</div>
	</div>
</template>
<script>
	Vue.component('template-field-repeat', {
		template: '#template-field-repeat',
		props: ['field', 'pointer'],
		mixins: [recursiveFieldMixin],
		components: {},
		data() {
			return {
			}
		},
		methods: {	// TODO: rewrite recursion more readable, especially remove
			remove(pointer, field_value, i, is_remove) {

				for (field of field_value.fields) {

					if (field.type != 'repeat') {

						if (!pointer || is_remove) {
							
							field.value.splice(i, 1)

						} else {

							let deep = field.value

							for (const pos of pointer) {
				
								deep = deep[pos]
							}

							deep.splice(i, 1)
						}

					} else {

						// if (!pointer) {
							
							field.value.length.splice(i, 1)

						// } else {

						// 	let deep = field.value.length

						// 	for (let i = 0; i < pointer.length - 1; i++) {

						// 		const pos = pointer[i]

						// 		deep = deep[pos]
						// 	}

						// 	deep.splice(i, 1)
						// }

						// probably doesnt work on recursion, depth > 2
						this.remove([...(pointer ?? []), i], field.value, i, true)
					}
				}

				if (is_remove) return

				if (!pointer) {

					field_value.length--

				} else {

					let deep = field_value.length
					
					for (let i = 0; i < pointer.length - 1; i++) {

						const pos = pointer[i]

						deep = deep[pos]
					}

					const last = pointer[pointer.length - 1]
					
					deep[last]--

					field_value.length = [...field_value.length]	// force update
				}
			},
			add() {

				for (field of this.field.value.fields) {

					if (field.type != 'repeat') {

						if (!this.pointer) {
							
							field.value.push(null)

						} else {

							field.value = this.add_recursive_value(
								JSON.parse(JSON.stringify(field.value))		// clone to avoid unnecessary mutation ?
							)
							
							// 	const i1 = this.pointer[0]
							// 	const i2 = this.pointer[1]
							// 	this.field.value.length[i1][i2].push(null)

							// [["elm 1","elm 2"],["elm 1"]]	// one recursion less than above
						}
					}
				}

				if (!this.pointer) {

					this.field.value.length++

				} else {

					this.field.value.length = this.add_recursive_length(
						JSON.parse(JSON.stringify(this.field.value.length))	// clone to avoid unnecessary mutation ?
					)

					// const i1 = this.pointer[0]
					// const i2 = this.pointer[1]
					// this.field.value.length[i1][i2]++

					// [2,1]	// one recursion less than above
				}
			},
			add_recursive_value(value) {

				let deep = value
	
				for (let i = 0; i < this.pointer.length; i++) {

					const pos = this.pointer[i]

					if (!deep[pos] && i < this.pointer.length - 1) {

						deep[pos] = []

					} else if (!deep[pos]) {

						deep[pos] = [null]

					} else {

						deep[pos].push(null)
					}
				}

				return value
			},
			add_recursive_length(length) {

				if (length == 0)
					length = []

				let deep = length
	
				for (let i = 0; i < this.pointer.length; i++) {

					const pos = this.pointer[i]

					if (!deep[pos] && i < this.pointer.length - 1) {

						deep[pos] = []

					} else if (!deep[pos]) {

						deep[pos] = 1

					} else {

						deep[pos]++
					}
				}

				return length
			},
		},
		computed: {
			length() {
	
				if (!this.pointer) {
	
					return this.field.value.length
				}
	
				let deep = this.field.value.length
	
				for (const pos of this.pointer) {
	
					deep = deep[pos]
				}
	
				return deep
			},
		},
		created() {
		},
	})
</script>