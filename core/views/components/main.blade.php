<script type="text/x-template" id="template-main">
    <div class="row">

        {{-- <div class="blocks-wrapper" v-if="allproducts || productsale || callbackall || allorders || orderstoday || ordersmonth">

            <h1>Общая информация</h1>
            <div class="blocks">
                <div class="iteminfo" v-if="allproducts">
                    <p>Всех товаров</p>
                    <span v-text="allproducts"></span>
                </div>
                <div class="iteminfo" v-if="productsale">
                    <p>Товаров продано</p>
                    <span v-text="productsale"></span>
                </div>
                <div class="iteminfo" v-if="callbackall">
                    <p>Оставлено заявок</p>
                    <span v-text="callbackall"></span>
                </div>
                <div class="iteminfo" v-if="allorders">
                    <p>Всех заказов</p>
                    <span v-text="allorders"></span>
                </div>
                <div class="iteminfo" v-if="orderstoday">
                    <p>Заказов за сегодня</p>
                    <span v-text="orderstoday"></span>
                </div>
                <div class="iteminfo" v-if="ordersmonth">
                    <p>Заказов за этот месяц</p>
                    <span v-text="ordersmonth"></span>
                </div>
            </div>
        </div>

        <div class="graphs">
            <div class="graph">
                <canvas id="myChart"></canvas>
            </div>
            <div class="graph">
                <canvas id="myChart2"></canvas>
            </div>
        </div>

        <div class="top-sales" v-if="products">
            <h1>Топ продаж</h1>
            <div class="itemstosale">
                <div v-for="product in products" :key='product.id'class="product">
                    <a v-bind:href="'/product/'+product.slug" target="_blank"><img v-bind:src="product.image" alt=""></a>
                    <a v-bind:href="'/product/'+product.slug" class="product-slug" target="_blank" v-text="product.title"></a>
                    <div class="product-count" v-text="'Продано: ' + product.count"></div>
                </div>
            </div>
        </div> --}}

    </div>
</script>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script> --}}

<script>
    Vue.component('template-main', {
        template: '#template-main',
        props: [],
        data: function () {
            return {
                allproducts: '',
                productsale: '',
                callbackall: '',
                allorders: '',
                orderstoday: '',
                ordersmonth: '',
                products: '',
                graph1: "0,0,0,0,0,0,0",
                graph2: "0,0,0,0,0,0,0",
            }
        },
        created: function(){

            // this.get_mainpage()

        },
        methods: {

            // get_mainpage: async function() {
                
            //     const response = await post('/admin/get-mainpage', {}, false, false)
            //     if (response.success){

            //         this.allproducts = response.data.firstblock.allproducts;
            //         this.productsale = response.data.firstblock.productsale;
            //         this.callbackall = response.data.firstblock.callbackall;
            //         this.allorders = response.data.firstblock.allorders;
            //         this.orderstoday = response.data.firstblock.orderstoday;
            //         this.ordersmonth = response.data.firstblock.ordersmonth;
            //         this.products = response.data.popproducts;
                    
            //         if (response.data.graph1) {
            //             this.graph1 = response.data.graph1.split(',').map(Number);
            //         }

            //         if (response.data.graph2) {
            //             this.graph2 = response.data.graph2.split(',').map(Number);
            //         } 

            //         this.initadmin();

            //     } else {
            //         alert('Error!')
            //     }
            // },

            // initadmin: function () {
            
            //     var firstDay = new Date();
            //     var day1 = firstDay.toLocaleDateString();
            //     var day2 = new Date(firstDay.getTime() - 1 * 24 * 60 * 60 * 1000).toLocaleDateString();
            //     var day3 = new Date(firstDay.getTime() - 2 * 24 * 60 * 60 * 1000).toLocaleDateString();
            //     var day4 = new Date(firstDay.getTime() - 3 * 24 * 60 * 60 * 1000).toLocaleDateString();
            //     var day5 = new Date(firstDay.getTime() - 4 * 24 * 60 * 60 * 1000).toLocaleDateString();
            //     var day6 = new Date(firstDay.getTime() - 5 * 24 * 60 * 60 * 1000).toLocaleDateString();;
            //     var day7 = new Date(firstDay.getTime() - 6 * 24 * 60 * 60 * 1000).toLocaleDateString();
            //     var days = [day1, day2, day3, day4, day5, day6, day7];
            //     var firstdata = this.graph1;

            //         var ctx = document.getElementById('myChart').getContext('2d');
            //     var myChart = new Chart(ctx, {
            //         type: 'line',
            //         data: {
            //             labels: days,
            //             datasets: [{
            //                 label: 'Заказов за день',
            //                 data: this.graph1,
            //                 backgroundColor: 'rgba(255, 99, 132, 0.2)',
            //                 borderWidth: 1,
            //                 borderColor: 'rgba(255, 99, 132, 0.2)',
            //             }]
            //         },
            //     });
            
            //     var ctx2 = document.getElementById('myChart2').getContext('2d');
            //     var myChart2 = new Chart(ctx2, {
            //         type: 'line',
            //         data: {
            //             labels: days,
            //             datasets: [{
            //                 label: 'Заявок за день',
            //                 data: this.graph2,
            //                 backgroundColor: 'rgba(255, 99, 132, 0.2)',
            //                 borderColor: 'rgba(255, 99, 132, 0.2)',
            //             }]
            //         },
            //     });
                
            // }
        },
    });
</script>
