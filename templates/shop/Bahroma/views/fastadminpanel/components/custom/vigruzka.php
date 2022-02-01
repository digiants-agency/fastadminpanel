<script type="text/x-template" id="template-vigruzka">
    <div class="vigruzka">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <button v-bind:class="{ active: tabs==1 }" class="nav-link" v-on:click="tabs=1">Загрузка файла</button>
            </li>
            <li class="nav-item">
                <button v-bind:class="{ active: tabs==2 }" class="nav-link "  v-on:click="tabs=2">Синхронизация полей</button>
            </li>
            <li class="nav-item">
                <button v-bind:class="{ active: tabs==3 }" class="nav-link "  v-on:click="tabs=3">Синхронизация категорий</button>
            </li>
            <li class="nav-item">
                <button v-bind:class="{ active: tabs==4 }" class="nav-link "  v-on:click="tabs=4">Синхронизация выгрузки</button>
            </li>
            <li class="nav-item">
                <button v-bind:class="{ active: tabs==5 }" class="nav-link "  v-on:click="tabs=5">Удаление товаров</button>
            </li>
            <li class="nav-item">
                <button v-bind:class="{ active: tabs==6 }" class="nav-link "  v-on:click="tabs=6">Експорт товаров</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">


            <div v-if="tabs==1" class="tab-pane show active">
                <hr>
                <form action="/">
                    <label for="">Файл который загружен сейчас {{data_sync_all.file_path}}</label>
                    <input class="form-control" type="file" id="file" ref="file" v-on:change="handleFileUpload()" >
                    <hr>
                    <label for="">Дата последнего обновления {{data_sync_all.last_upd}}</label>
                    <hr>
                    <input class="btn btn-success" v-on:click="savesyncdata()" value="Перезаписать">
                </form>
            </div>


            <div v-if="tabs==2" class="tab-pane show active">
                <hr>
                <button class="btn btn-success" v-on:click="getfieldsdata()">Загрузить все поля и сопоставления</button>
                <hr>
                <div class="row" v-for="file_cycle_field in file_fields" style="margin-bottom: 5px">
                    <div class="col-md-5">
                        <select class="form-control" v-model="file_cycle_field[1]">
                            <option v-for="d_f in data_fields" :value="d_f.id">{{d_f.title}}</option>
                        </select>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" disabled readonly :value="file_cycle_field[0]"></div>
                </div>
                <hr v-if="showresavedata==1">
                <button class="btn btn-warning" v-if="showresavedata==1" v-on:click="resavefieldsdata()">Перезаписать связи</button>
            </div>


            <div v-if="tabs==3" class="tab-pane show active">
                <hr>
                <button class="btn btn-success" v-on:click="getcatsdata()">Загрузить все категории</button>
                <hr>
                <div class="row" v-for="cat in catsdata" style="margin-bottom: 5px">
                    <div class="col-md-5">
                        <select class="form-control">
                            <option v-for="c_f_s in cats_from_site" :value="c_f_s[0]">{{c_f_s[1]}}</option>
                        </select>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" disabled readonly :value="cat"></div>
                </div>
                <hr v-if="showrecatsdata==1">
                <button class="btn btn-warning" v-if="showrecatsdata==1" v-on:click="resavecatssdata()">Перезаписать связи</button>
            </div>


            <div v-if="tabs==4" class="tab-pane show active">
                <hr>
                <h2>Инструкция</h2>
                <p>Описать как пользоватся этой "страшной" штукой</p>
                <hr>
                <div style="display: flex;">
                    <h2>With love From</h2>
                    <img src="https://digiants.agency/images/logo-full.svg" alt="" style="width: 300px; margin-left: 15px;">
                </div>
                <hr>
                <button class="btn btn-success">Посмотреть первый товар</button>
                <hr>
                <button class="btn btn-danger">Перезаписать все товары</button>
            </div>


            <div v-if="tabs==5" class="tab-pane show active">
                <hr>
                <button class="btn btn-danger">Удалить все товары</button>
                <hr>
                <button class="btn btn-warning">Удалить все категории</button>
                <hr>
                <button class="btn btn-info">Удалить все фильтра</button>
            </div>

            <div v-if="tabs==6" class="tab-pane show active">
                <hr>
                <button class="btn btn-danger">Скачать все товары</button>
            </div>


        </div>

    </div>
</script>

<script>
    Vue.component('template-vigruzka',{
        template: '#template-vigruzka',
        data: function () {
            return {
                data_sync_all: '',
                data_sync: '',
                data_sync_cats: '',
                tabs: 4,
                data_fields: '',
                file_fields: '',
                catsdata: '',
                cats_from_site: '',
                showresavedata: 0,
                showrecatsdata: 0,
            }
        },
        created: function(){
            var arr = [];
            var app = this;
            $.ajax({
                type: 'POST',
                url: '/admin/getsyncdata',
                headers: {
                    "Accept": "application/json",
                    "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).done(function(data){
                arr = JSON.parse(data);
                console.log(arr);
                this.data_sync_all = arr.data_sync_all;
                this.data_sync = arr.data_sync;
                this.data_sync_cats = arr.data_sync_cats;
                console.log(arr.data_sync_cats);
            }.bind(this));
        },
        methods: {
            savesyncdata: async function(){
                if(this.xmlfile!='') {

                    var response = await post ('/admin/savefilesyncdata', {file: this.xmlfile}, true);

                    if (!response.success) {
                        alert('Error')
                        return
                    } else {
                        alert('Файл успешно обновлен!');
                    }

                } else alert('Файл не выбран');
            },

            handleFileUpload: function(){
                this.xmlfile = this.$refs.file.files[0];
            },

            getfieldsdata: async function(){
                var response = await post ('/getfieldsdata', {});
                if (!response.success) {
                    alert('Error')
                    return
                } else {
                    this.data_fields = response.data.fields;
                    this.file_fields = response.data.filefields;
                    this.showresavedata = 1;
                    console.log(response.data);
                }
            },

            getcatsdata: async function(){
                var response = await post ('/loadcatsdata', {});
                if (!response.success) {
                    alert('Error')
                    return
                } else {
                    this.catsdata = response.data.filefields;
                    this.cats_from_site = response.data.fields;
                    this.showrecatsdata = 1;
                    console.log(response.data);

                }
            },

            resavefieldsdata: async function(){
                if(confirm('Вы уверены что хотите перезаписать все поля?')){
                    console.log(this.file_fields);
                    var response = await post ('/admin/resavefieldsdata', {sync_fields: this.file_fields});
                    if(response.success) alert('Успешно перезаписано'); else alert('Что-то не работает. Свяжитесь с разработчиком. ');
                }
            },

            resavecatssdata: async function(){
                console.log('SAVE DATA');
            }
        },

        beforeDestroy: function(){

        },
    })
</script>

<style>

</style>
