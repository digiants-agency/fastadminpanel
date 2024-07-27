<template id="single-edit-fields">
    <div class="menu-table-editfields">
        <div class="table">
            <div class="flex a-center">
                <div class="table-col table-header-title">Lang</div>
                <div class="table-col table-header-title">Field type</div>
                <div class="table-col table-header-title">Field API name</div>
                <div class="table-col table-header-title">Field visual name</div>
            </div>
            <div v-for="(field, index) in block.fields">
                <div class="flex a-center w-100">
                    <div class="table-col menu-table-field">
                        <div class="menu-table-field-td-wrapper">
                            <div class="select-wrapper">
                                <select v-model="field.is_multilanguage" class="form-control type" v-on:change="blockChanged">
                                    <option value="1">Separate</option>
                                    <option value="0">Common</option>
                                </select>
                                <div class="select-arrow-block">
                                    <img class="select-arrow" src="/vendor/fastadminpanel/images/dropdown-ico.svg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-col menu-table-field">
                        <div class="menu-table-field-td-wrapper">

                            <div class="select-wrapper">
                                <select v-model="field.type" class="form-control type" v-on:change="blockChanged">
                                    <option value="text">Text</option>
                                    <option value="textarea">Long text</option>
                                    <option value="ckeditor">Ckeditor</option>
                                    <option value="checkbox">Checkbox</option>
                                    <option value="color">Color picker</option>
                                    <option value="date">Date picker</option>
                                    <option value="datetime">Date and time picker</option>
                                    <option value="relationship">Relationship (unaviable)</option>
                                    <option value="file">File</option>
                                    <option value="photo">Photo</option>
                                    <option value="gallery">Gallery</option>
                                    <option value="money">Money</option>
                                    <option value="number">Number</option>
                                    <option value="repeat">Repeat</option>
                                </select>
                                <div class="select-arrow-block">
                                    <img class="select-arrow" src="/vendor/fastadminpanel/images/dropdown-ico.svg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="table-col menu-table-field">
                        <div class="menu-table-field-td-wrapper">
                            <input v-model="field.slug" type="text" class="form-control title" placeholder="Slug" v-on:change="blockChanged">
                        </div>
                    </div>
                    <div class="table-col menu-table-field">
                        <div class="menu-table-field-td-wrapper">
                            <input v-model="field.title" type="text" class="form-control title" placeholder="Title" v-on:change="blockChanged">
                        </div>
                    </div>
                    <div class="table-col table-col-last menu-table-field">
                        <div class="menu-table-field-td-wrapper">
                            <div class="menu-table-flex-btns">
                                <div v-on:click="upField(index)" class="btn btn-blue btn-small">
                                    <img src="/vendor/fastadminpanel/images/up.svg" alt="" class="btn-svg">
                                </div>
                                <div v-on:click="removeField(index)" class="rem btn btn-danger btn-small">
                                    <img src="/vendor/fastadminpanel/images/close.svg" alt="" class="btn-svg">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <single-edit-fields :block="field" :index="index" v-if="field.type == 'repeat'" v-on:blockchanged="handleChange" />
            </div>
        </div>
        <button v-on:click="addField()" type="button" class="btn btn-add"><span class="btn-plus">+</span> Add field</button>
    </div>
</template>

<script>
// TODO: refactor
app.component('single-edit-fields', {
	template: '#single-edit-fields',
	props: ['block', 'index'],
	data() {
		return {
		}
	},
	methods: {
		removeField(index) {

			this.block.fields.splice(index, 1)
			this.blockChanged()
		},
		upField(index) {

			if (index > 0) {
				const temp = this.block.fields[index]
				this.block.fields[index] = this.block.fields[index - 1]
				this.block.fields[index - 1] = temp
				this.blockChanged()
			}
		},
		addField() {

			let id = 0
			const fields = this.block.fields

			if (fields && fields.length > 0) {
				for (let i = 0; i < fields.length; i++) {
					if (fields[i].id > id)
						id = fields[i].id
				}
				id++
			} else {
				this.block.fields = []
			}

			this.block.fields.push({id: id, is_multilanguage: 1})
			this.blockChanged()
		},
		blockChanged() {
			
			this.$forceUpdate()
			this.$emit('blockchanged', {
				block: this.block,
				index: this.index
			})
		},
		handleChange(event) {

			this.block.fields[event.index] = event.block
			this.blockChanged()
		},
	},
})
</script>