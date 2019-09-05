Vue.component('template-languages',{
    template: '#template-languages',
    props: [],
    data: function () {
        return {

        }
    },
    methods: {
        update_language: function(){
            request('/admin/update-languages', {}, function(data){
                if (data == 'Success') document.location.reload()
                else alert('Error: ' + data)
            })
        },
    },
    mounted: function(){
        
    }
})