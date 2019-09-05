Vue.component('template-content',{
    template: '#template-content',
    props:[],
    data: function () {
        return {
            menu_item: {title: ''},
            content: '',            // Edit table, Show table, Edit row
        }
    },
    mounted: function(){
        this.$root.$on('set_menu', (item)=>{

            this.menu_item = item

            if (item.title == 'Menu') {
                
                this.content = 'Edit table'
            
            } else if (item.title == 'Languages') {

                this.content = 'Languages'

            } else {

                var order = ''
                for (var i = 0; i < item.fields.length; i++) {
                    if (item.fields[i].show_in_list != 'no') {
                        order = item.fields[i].db_title
                        break
                    }
                }

                this.content = 'Index table'
                this.$refs.index.init(item, order)
            }
        })
    }
})