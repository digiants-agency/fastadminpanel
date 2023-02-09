<script>
const recursiveFieldMixin = {
	computed: {
		value: {
			set(val) {
				
				if (!this.pointer) {

					this.field.value = val

				} else {

					let deep = this.field.value

					for (let i = 0; i < this.pointer.length - 1; i++) {
						
						const pos = this.pointer[i]
						deep = deep[pos]
					}

					const last = this.pointer[this.pointer.length - 1]

					deep[last] = val

					this.field.value = [...this.field.value]	// launch mutation
				}
			},
			get() {

				if (!this.pointer) {

					return this.field.value ?? this.default
				}

				let deep = this.field.value

				for (let i = 0; i < this.pointer.length; i++) {
					
					const pos = this.pointer[i]
					deep = deep[pos]
				}

				return deep ?? this.default
			},
		},
		default() {

			return ''
		},
	},
}
</script>