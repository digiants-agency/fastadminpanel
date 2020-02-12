Vue.component('template-sidebar',{
    template: '#template-sidebar',
    props:['is_dev', 'menu'],
    data: function () {
        return {
        }
    },
    methods: {
        set_menu: function(item) {

            for (var i in this.menu) {  // is menu the same
                if (item == this.menu[i] && this.menu[i].active) {
                    this.$root.$emit('set_menu_back')
                    return
                }
            }

            for (var i in this.menu) {
                this.menu[i].active = false
            }
            item.active = true
            this.$root.$emit('set_menu', item)
        },
    },
    mounted: function(){
    },
})