Vue.component('template-index',{

    template: '#template-index',
    data: function () {
        return {
            menu_item: {},
            order: '',
            sort_order: 'DESC',
            count: 0,
            offset: 0,
            instances: [],
            edit_id: 0,
            edit_unique_id: 0,
            is_edit: false,
            search_timeout: null,
            search: '',
            marked: [],
        }
    },
    methods: {
        set_back: function(is_refresh){
            this.is_edit = false
            if (is_refresh) {
                this.refresh()
            }
        },
        remove_row: function(id){

            if (confirm("Are you sure?")) {
                
                request('/admin/db-remove-row', {
                    table_name: this.menu_item.table_name,
                    language: (this.menu_item.multilanguage == 0) ? '' : app.get_language().tag,
                    id: id,
                }, (data)=>{
                    if (data == 'Success') {
                        this.refresh()
                    } else {
                        alert('Error. Press OK to reload page')
                        location.reload()
                    }
                })
            }
        },
        edit_row: function(id){
            this.edit_id = id
            this.is_edit = true
        },
        add_new_row: function(){
            this.edit_id = 0
            this.is_edit = true
        },
        get_fields_instances: function(){

            var where = ''

            if (this.search.length > 1) {

                var where_arr = []

                for (var i = 0; i < this.menu_item.fields.length; i++) {

                    var field = this.menu_item.fields[i]

                    if (field.show_in_list != 'no') {
                        
                        where_arr.push(field.db_title + ' LIKE "%' + this.search + '%"')
                    }
                }
                where = where_arr.join(' OR ')
            }
            
            request('/admin/db-select', {
                table: this.menu_item.table_name,
                order: this.order,
                sort_order: this.sort_order,
                offset: this.offset,
                language: (this.menu_item.multilanguage == 0) ? '' : app.get_language().tag,
                where: where,
                limit: 10,
            }, (data)=>{

                data.forEach((elm)=>{
                    elm.marked = false
                })

                this.instances = data

                this.rerender_edit()
            })
        },
        rerender_edit: function(){
            this.edit_unique_id++
        },
        get_count: function(){
            request('/admin/db-select', {
                table: this.menu_item.table_name,
                fields: 'id',
                offset: 0,
                language: (this.menu_item.multilanguage == 0) ? '' : app.get_language().tag,
                limit: 999999,
            }, (data)=>{
                this.count = data.length
                this.get_fields_instances()
            })
        },
        prev_page: function(){
            if (this.curr_page != 1 && this.pages_count > 1)
                this.curr_page--
        },
        next_page: function(){
            if (this.curr_page != this.pages_count && this.pages_count > 1)
                this.curr_page++
        },
        delete_checked: function(){

            if (confirm("Are you sure?")) {

                var ids = []

                this.instances.forEach((elm)=>{
                    if (elm.marked)
                        ids.push(elm.id)
                })
                
                request('/admin/db-remove-rows', {
                    table_name: this.menu_item.table_name,
                    language: (this.menu_item.multilanguage == 0) ? '' : app.get_language().tag,
                    ids: JSON.stringify(ids),
                }, (data)=>{
                    if (data == 'Success') {
                        this.refresh()
                    } else {
                        alert('Error. Press OK to reload page')
                        location.reload()
                    }
                })
            }
        },
        set_marked: function(is_mark){
            this.instances.forEach((elm)=>{
                elm.marked = is_mark
            })
        },
        refresh: function(){
            // TODO: make only one request
            this.get_count()
        },
        init: function(menu_item, order){
            this.is_edit = false
            this.menu_item = menu_item
            this.order = order
            this.offset = 0
            this.get_count()
        },
    },
    computed: {
        pages_count: function(){
            return Math.ceil(this.count / 10)
        },
        curr_page: {
            get: function(){
                return parseInt(this.offset / 10) + 1
            },
            set: function(newValue){
                // console.log('set curr_page')
                this.offset = (newValue - 1) * 10
                this.get_fields_instances()
            },
        },
    },
    watch: {
        // order: function(val){
        //     this.get_fields_instances()
        // },
        // menu_item: function(){
        //     console.log('menu_item change')
        //     this.init()
        // },
        search: function(val){

            if (this.search_timeout != null) clearTimeout(this.search_timeout)

            this.search_timeout = setTimeout(()=>{
                
                this.refresh()
            }, 500)
        },
    },
    created: function(){
    },
    mounted: function(){
        this.$root.$on('set_language', (lang)=>{

            this.refresh()
        })
    },
})