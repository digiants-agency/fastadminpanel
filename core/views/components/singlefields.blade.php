<template id="template-singlefields">
    <div class="menu-table-editfields">

        <div class="table">
            <div class="flex a-center">
                <div class="table-col table-header-title">Lang</div>
                <div class="table-col table-header-title">Field type</div>
                <div class="table-col table-header-title">Field visual name</div>
                <div class="table-col table-header-title">Field API name</div>
            </div>
            <div v-for="(field, index) in block.fields" >
                <div class="flex a-center w-100">
                    <div class="table-col menu-table-field">
                        <div class="menu-table-field-td-wrapper">
                            <div class="select-wrapper">
                                <select v-model="field.is_multilanguage" class="form-control type" v-on:change="blockChange">
                                    <option value="1">Separate</option>
                                    <option value="0">Common</option>
                                </select>
                                <div class="select-arrow-block">
                                    <svg class="select-arrow" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
                                        <clipPath id="clip0_755_2893">
                                        <rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
                                        </clipPath>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-col menu-table-field">
                        <div class="menu-table-field-td-wrapper">

                            <div class="select-wrapper">
                                <select v-model="field.type" class="form-control type" v-on:change="blockChange">
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
                                    <svg class="select-arrow" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
                                        <clipPath id="clip0_755_2893">
                                        <rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
                                        </clipPath>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-col menu-table-field">
                        <div class="menu-table-field-td-wrapper">
                            <input v-model="field.title" type="text" class="form-control title" placeholder="Название" v-on:change="blockChange">
                        </div>
                    </div>
                    <div class="table-col menu-table-field">
                        <div class="menu-table-field-td-wrapper">
                            <input v-model="field.slug" type="text" class="form-control title" placeholder="Название" v-on:change="blockChange">
                        </div>
                    </div>
                    <div class="table-col table-col-last menu-table-field">
                        <div class="menu-table-field-td-wrapper">
                            <div class="menu-table-flex-btns">
                                <div v-on:click="upMenuItem(index)" class="btn btn-blue btn-small">
                                    <svg class="btn-svg" width="10" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.45962 0.54038C5.20578 0.28654 4.79422 0.28654 4.54038 0.54038L0.403806 4.67696C0.149965 4.9308 0.149965 5.34235 0.403806 5.59619C0.657647 5.85003 1.0692 5.85003 1.32304 5.59619L5 1.91924L8.67696 5.59619C8.9308 5.85003 9.34235 5.85003 9.59619 5.59619C9.85003 5.34235 9.85003 4.9308 9.59619 4.67696L5.45962 0.54038ZM5.65 9L5.65 1L4.35 1L4.35 9L5.65 9Z" fill="#171219"/>
                                    </svg>
                                </div>
                                <div v-on:click="removeMenuItem(index)" class="rem btn btn-danger btn-small">
                                    <svg class="btn-svg" width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.88111 4.00011L7.8722 1.00889C7.95447 0.926545 7.99987 0.816691 8 0.699553C8 0.58235 7.9546 0.472366 7.8722 0.390155L7.61008 0.128106C7.52767 0.0455695 7.41782 0.000366211 7.30055 0.000366211C7.18348 0.000366211 7.07363 0.0455695 6.99122 0.128106L4.00013 3.11913L1.00891 0.128106C0.926634 0.0455695 0.816715 0.000366211 0.699512 0.000366211C0.582439 0.000366211 0.47252 0.0455695 0.390244 0.128106L0.128 0.390155C-0.0426667 0.560821 -0.0426667 0.838415 0.128 1.00889L3.11915 4.00011L0.128 6.9912C0.0456585 7.07367 0.000325203 7.18352 0.000325203 7.30066C0.000325203 7.4178 0.0456585 7.52765 0.128 7.61006L0.390179 7.87211C0.472455 7.95458 0.582439 7.99985 0.699447 7.99985C0.81665 7.99985 0.926569 7.95458 1.00885 7.87211L4.00006 4.88102L6.99115 7.87211C7.07356 7.95458 7.18341 7.99985 7.30049 7.99985H7.30062C7.41776 7.99985 7.52761 7.95458 7.61002 7.87211L7.87213 7.61006C7.95441 7.52772 7.9998 7.4178 7.9998 7.30066C7.9998 7.18352 7.95441 7.07367 7.87213 6.99126L4.88111 4.00011Z" fill="white"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <template-singlefields :block="field" :index="index" v-if="field.type == 'repeat'" v-on:blockchange="handleChange" />

            </div>

        </div>

        <button v-on:click="addMenuItem()" type="button" id="addField" class="btn btn-add"><span class="btn-plus">+</span> Add field</button>

    </div>
</template>

<script>
	Vue.component('template-singlefields',{
		template: '#template-singlefields',
        props: ['block', 'index'],
		data: function () {
			return {
			}
		},
		methods: {
			removeMenuItem(index) {

				this.block.fields.splice(index, 1)
                this.blockChange()
			},
			upMenuItem(index) {

				if (index > 0) {
					var temp = this.block.fields[index]
					this.block.fields[index] = this.block.fields[index - 1]
					this.block.fields[index - 1] = temp
                    this.blockChange()
				}
			},
			addMenuItem() {

				var id = 0
				const fields = this.block.fields

                if (fields && fields.length > 0) {
                    for (var i = 0; i < fields.length; i++) {
                        if (fields[i].id > id)
                            id = fields[i].id
                    }
                    id++
                } else {
                    this.block.fields = []
                }

				this.block.fields.push({id: id, is_multilanguage: 1})
                this.blockChange()
			},
            blockChange() {
                
                this.$forceUpdate()
                this.$emit('blockchange', {
                    block: this.block,
                    index: this.index
                })
            },
            handleChange(event) {

				this.block.fields[event.index] = event.block
                this.blockChange()
			},
		},
		watch: {
		},
		created: function(){
		},
	})
</script>