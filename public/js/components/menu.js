Vue.component('template-menu',{
    template: '#template-menu',
    props:[],
    data: function () {
        return {
            menu: app.menu,
            action: 'create',
            to_remove: [],
            template: {
                table_name: '',
                title: '',
                is_soft_delete: 0,
                is_dev: 0,
                multilanguage: 1,
                sort: 10,
                fields: [],
            },
            menu_item_edit: {
                table_name: '',
                title: '',
                is_soft_delete: 0,
                is_dev: 0,
                multilanguage: 1,
                sort: 10,
                fields: [],
            },
        }
    },
    methods: {
        set_menu_item: function(e){
            var id = e.target.value

            if (id == -1) {
                this.menu_item_edit = Object.assign({}, this.template)
                this.action = 'create'
            } else {
                this.menu_item_edit = this.menu[id]
                this.to_remove = []
                this.action = 'edit'
            }
        },
        remove_menu_item: function(index) {
            this.to_remove.push(this.menu_item_edit.fields[index].id)
            this.menu_item_edit.fields.splice(index, 1)
        },
        up_menu_item: function(index) {
            if (index > 0) {
                var temp = this.menu_item_edit.fields[index]
                this.menu_item_edit.fields[index] = this.menu_item_edit.fields[index - 1]
                this.menu_item_edit.fields[index - 1] = temp
                this.$forceUpdate()
            }
        },
        add_menu_item: function(){

            var id = 0
            if (this.menu_item_edit.fields.length > 0)
                id = this.menu_item_edit.fields[this.menu_item_edit.fields.length - 1].id + 1

            this.menu_item_edit.fields.push({id: id, required: 'optional', is_visible: true, lang: 1, show_in_list: 'no'})
        },
        create_crud: function(){
            
            request('/admin/db-create-table', {
                table_name: this.menu_item_edit.table_name, 
                title: this.menu_item_edit.title,
                is_soft_delete: this.menu_item_edit.is_soft_delete,
                is_dev: this.menu_item_edit.is_dev,
                multilanguage: this.menu_item_edit.multilanguage,
                sort: this.menu_item_edit.sort,
                fields: JSON.stringify(this.menu_item_edit.fields),
            }, (data)=>{
                if (data == 'Success') {
                    location.reload()
                }
            })
        },
        update_crud: function(){

            request('/admin/db-update-table', {
                id: this.menu_item_edit.id,
                table_name: this.menu_item_edit.table_name, 
                title: this.menu_item_edit.title,
                is_soft_delete: this.menu_item_edit.is_soft_delete,
                is_dev: this.menu_item_edit.is_dev,
                multilanguage: this.menu_item_edit.multilanguage,
                sort: this.menu_item_edit.sort,
                fields: JSON.stringify(this.menu_item_edit.fields),
                to_remove: JSON.stringify(this.to_remove),
            }, (data)=>{
                if (data == 'Success') {
                    location.reload()
                }
            })
        },
        remove_crud: function(){

            if (confirm("Are you sure?")) {
                request('/admin/db-remove-table', {
                    id: this.menu_item_edit.id,
                    table_name: this.menu_item_edit.table_name, 
                }, (data)=>{
                    if (data == 'Success') {
                        location.reload()
                    }
                })
            }
        },
        get_fields_by_table_name: function(table_name){

            var fields = []

            this.menu.forEach((elm)=>{
                if (elm.table_name == table_name) {
                    fields = elm.fields
                    return
                }
            })

            return fields
        },
        add_enum: function(select){
            select.push('')
            this.$forceUpdate()
        },
        remove_enum: function(select){
            select.splice(-1,1)
            this.$forceUpdate()
        },
    },
    watch: {
        'menu_item_edit.fields': function(fields){
            fields.forEach((field)=>{
                if (field.type == 'enum' && field.enum == undefined) {
                    field.enum = []
                } else if (field.type != 'enum' && field.enum != undefined) {
                    delete field.enum;
                }
            })
        }
    },
    mounted: function(){
        
    },
})