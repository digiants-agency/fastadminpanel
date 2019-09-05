Vue.component('template-edit',{
    template: '#template-edit',
    props: ['menu_item', 'id', 'language_id'],
    components: {
        // Use the <ckeditor> component in this view.
        ckeditor: CKEditor.component
    },
    data: function () {
        return {
            fields_instance: {},
            errors: {},
            is_loading: false,
            editor: ClassicEditor,
            editorConfig: {
                extraPlugins: [ MyCustomUploadAdapterPlugin ],
            },
            relationships: {},
        }
    },
    methods: {
        unprepare_fields: function(fields){

            this.menu_item.fields.forEach((field)=>{

                if (field.type == 'gallery' && fields[field.db_title]) {
                    fields[field.db_title] = JSON.parse(fields[field.db_title])
                }
            })

            return fields
        },
        prepare_fields: function(fields_instance){
            
            var prepared_field_instance = Object.assign({}, fields_instance)

            this.menu_item.fields.forEach((field)=>{

                if (field.type == 'gallery') {
                    prepared_field_instance[field.db_title] = JSON.stringify(fields_instance[field.db_title])
                }
            })

            return prepared_field_instance
        },
        create_fields_instance: function(){

            this.check_fields(()=>{

                var fields = this.prepare_fields(this.fields_instance)

                request('/admin/db-insert-or-update-row', {
                    table_name: this.menu_item.table_name,
                    fields: JSON.stringify(fields),
                    language: (this.menu_item.multilanguage == 0) ? '' : app.get_language().tag,
                    id: this.id,
                }, (data)=>{
                    if (data == 'Success') {
                        this.back(true)
                    } else {
                        alert('Error. Press OK to reload page')
                        location.reload()
                    }
                })
            })            
        },
        check_fields: function(callback){

            this.menu_item.fields.forEach((field)=>{

                check_required(this.errors, this.fields_instance, field)
                check_type(this.errors, this.fields_instance, field)
            })

            var is_valid = true
            this.menu_item.fields.forEach((field)=>{

                if (this.errors[field.db_title] != '')
                    is_valid = false
            })


            if (is_valid)
                callback()

            function check_required(errors, instance, field) {

                if (instance[field.db_title] == undefined && field.required == 'optional') {
                    if (field.type == 'relationship' && field.relationship_count == 'single' && instance['id_' + field.relationship_table_name] == undefined)
                        instance['id_' + field.relationship_table_name] = 0
                    else if (field.type != 'relationship') {
                        instance[field.db_title] = get_standart_val(field.type)
                    }
                }
                
                if (field.required != 'optional' && instance[field.db_title] == '') {
                    errors[field.db_title] = 'This field is required'
                } else if (field.required == 'required_once') {
                    // TODO
                }

                function get_standart_val(type) {
                    // TODO: enum, relationship
                    if (type == 'checkbox' || type == 'money' || type == 'number') return 0
                    if (type == 'color') return '#000000'
                    if (type == 'date') return '2000-00-00'
                    if (type == 'datetime') return '2000-00-00 12:00:00'
                    if (type == 'gallery') return []
                    if (type == 'repeat') return ''
                    return ''
                }
            }

            function check_type(errors, instance, field) {
                
                if (field.type == 'text') {
                    if (instance[field.db_title].length > 191)
                        errors[field.db_title] = 'More than maxlength (191 symbols)'
                } else if (field.type == 'number' || field.type == 'money') {
                    if (!$.isNumeric(instance[field.db_title]))
                        errors[field.db_title] = 'Field must be numeric. Use "." instead of ","'
                }
            }
        },
        add_photo: function(id){

            window.open('/laravel-filemanager?type=image', 'FileManager', 'width=900,height=600');
            window.SetUrl = (items)=>{

                for (var i = 0; i < items.length; i++) {

                    var url = items[i].url.replace(document.location.origin, '')

                    this.fields_instance[id] = url
                    this.$forceUpdate()

                    break;
                }
            };
        },
        add_gallery: function(id){
            window.open('/laravel-filemanager?type=image', 'FileManager', 'width=900,height=600');
            window.SetUrl = (items)=>{

                if (this.fields_instance[id])
                    var arr = this.fields_instance[id]
                else  var arr = []
                
                for (var i = 0; i < items.length; i++) {

                    var url = items[i].url.replace(document.location.origin, '')
                    arr.push(url)
                }
                this.fields_instance[id] = arr
                this.$forceUpdate()
            };
        },
        remove_gallery: function(id, index){
            this.fields_instance[id].splice(index, 1)
        },
        init_color: function(){

            var app = this
            $(".colorpicker").each((i, elm)=>{

                var id = $(elm).attr('id')
                var c = '#000000'

                if (app.fields_instance[id] != undefined && app.fields_instance[id] != '')
                    c = app.fields_instance[id]

                $(elm).spectrum({
                    color: c,
                    change: function(color) {
                        var hex = color.toHexString()
                        app.fields_instance[id] = hex
                    }
                })
            })
        },
        get_relationships: function(stack, callback){
            
            if (stack.length == 0) {

                callback()
                return
            }

            var field = stack.pop()
            
            request('/admin/db-relationship', {
                // table_name: this.menu_item.table_name,
                language: app.get_language().tag,
                field: JSON.stringify(field)
            }, (data)=>{

                // this.relationships[field.relationship_table_name] = data                
                Vue.set(this.relationships, field.relationship_table_name, data)
                this.get_relationships(stack, callback)
            })
        },
        add_relationship_field: function(field){

            var relationships = this.relationships[field.relationship_table_name]

            var add = {}

            if (relationships.length > 0)
                add[field.relationship_table_name] = relationships[0].id
            else add[field.relationship_table_name] = 0

            this.fields_instance['$' + this.menu_item.table_name + '_' + field.relationship_table_name].push(add)
            this.$forceUpdate()
        },
        remove_relationship_field: function(field, id){
            
            this.fields_instance['$' + this.menu_item.table_name + '_' + field.relationship_table_name].splice(id, 1)
            this.$forceUpdate()
        },
        test: function(param1){
            console.log(this.fields_instance[param1])
            console.log(JSON.stringify(this.fields_instance))
        },
        refresh: function(){

            var stack = []

            this.menu_item.fields.forEach((field)=>{

                Vue.set(this.errors, field.db_title, '')

                if (field.type == 'relationship') {
                    
                    stack.push(field)
                
                    if (field.relationship_count == 'many') {
                        this.fields_instance['$' + this.menu_item.table_name + '_' + field.relationship_table_name] = []
                    }
                }
            })

            this.get_relationships(stack, ()=>{
                
                if (this.id != 0) {

                    this.is_loading = true

                    var rels = []
                    for (i in this.menu_item.fields) {
                        var field = this.menu_item.fields[i]
                        if (field.relationship_count == 'many')
                            rels.push([this.language_id, this.menu_item.table_name + '_' + field.relationship_table_name, field.relationship_table_name])
                    }
                    if (rels.length > 0) rels = JSON.stringify(rels)
                    else rels = ''
                    
                    request('/admin/db-select', {
                        table: this.menu_item.table_name,
                        where: 'language_id=' + this.language_id + ' AND language="' + app.get_language().tag + '"',
                        relationships: rels,
                        limit: 1,
                    }, (data)=>{
                        this.is_loading = false
                        this.fields_instance = this.unprepare_fields(data[0])
                        this.init_color()
                    })
                } else {
                    this.init_color()
                }
            })
        },
        back: function(is_need_refresh){
            this.$emit('back', is_need_refresh)
        },
    },
    created: function(){

        this.refresh()
    },
    mounted: function(){

        this.$root.$on('set_language', (lang)=>{

            this.refresh()
        })
    },
})