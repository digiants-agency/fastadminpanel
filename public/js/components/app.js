var app = new Vue({
    el: '#app',
    data: {
        is_dev: location.pathname == '/admin/dev',
        menu: [],
        languages: languages,
    },
    methods: {
        get_language: function(){
            for (i in this.languages) {
                if (this.languages[i].is_active)
                    return this.languages[i]
            }
            return null
        },
        set_language: function(lang){

            for (i in this.languages) {
                if (this.languages[i].id == lang.id) {

                    this.languages[i].is_active = true
                    this.$root.$emit('set_language', lang)
                    set_cookie('lang', lang.tag, 30)

                } else this.languages[i].is_active = false
            }
            this.$forceUpdate()
        },
    },
    created: function(){
        
        for (i in this.languages) {
            if (this.languages[i].main_lang == 1) {

                this.languages[i].is_active = true
                set_cookie('lang', this.languages[i].tag, 30)

            } else this.languages[i].is_active = false
        }

        request('/admin/db-select', {table: 'menu', order: 'sort'}, (data)=>{
            for (var i in data) {
                data[i].active = false
                data[i].fields = JSON.parse(data[i].fields)
            }
            this.menu = data
        })
    },
    mounted: function(){

    },
})