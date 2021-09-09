<script type="text/x-template" id="template-main">
    <div class="row">
        <h1>Административная панель</h1>
        <div class="blocks">
            <div class="iteminfo">
                <p>Всех товаров</p>
                <span>{{allproducts}}</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                    <path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                </svg>
            </div>
            <div class="iteminfo">
                <p>Товаров продано</p>
                <span>{{productsale}}</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                    <path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                </svg>
            </div>
            <div class="iteminfo">
                <p>Оставлено заявок</p>
                <span>{{callbackall}}</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                    <path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                </svg>
            </div>
            <div class="iteminfo">
                <p>Всех заказов</p>
                <span>{{allorders}}</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                    <path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                </svg>
            </div>
            <div class="iteminfo">
                <p>Заказов за сегодня</p>
                <span>{{orderstoday}}</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                    <path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                </svg>
            </div>
            <div class="iteminfo">
                <p>Заказов за этот месяц</p>
                <span>{{ordersmonth}}</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                    <path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                </svg>
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

        <h1>Топ продаж</h1>
        <div class="itemstosale">
            <div v-for="product in products" :key='product.id'class="product">
                <a v-bind:href="'/'+product.slug" target="_blank"><img v-bind:src="product.image" alt=""></a>
                <a v-bind:href="'/'+product.slug" target="_blank">{{product.title}}</a>
            </div>
        </div>
    </div>
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>

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
                graph1: '',
                graph2: '',
            }
        },
        created: function(){
            var arr = [];
            $.ajax({
                type: 'POST',
                url: '/admin/getdata',
                headers: {
                    "Accept": "application/json",
                    "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).done(function(data){
                arr = JSON.parse(data);
                this.allproducts = arr.firstblock.allproducts;
                this.productsale = arr.firstblock.productsale;
                this.callbackall = arr.firstblock.callbackall;
                this.allorders = arr.firstblock.allorders;
                this.orderstoday = arr.firstblock.orderstoday;
                this.ordersmonth = arr.firstblock.ordersmonth;
                this.products = arr.popproducts;
                this.graph1 = arr.graph1.split(',').map(Number);
                this.graph2 = arr.graph2.split(',').map(Number);
                this.initadmin();
            }.bind(this));
        },
        methods: {
            initadmin: function () {
                var ctx = document.getElementById('myChart').getContext('2d');
                var ctx2 = document.getElementById('myChart2').getContext('2d');
                var firstDay = new Date();
                var day1 = firstDay.toLocaleDateString();
                var day2 = new Date(firstDay.getTime() - 1 * 24 * 60 * 60 * 1000).toLocaleDateString();
                var day3 = new Date(firstDay.getTime() - 2 * 24 * 60 * 60 * 1000).toLocaleDateString();
                var day4 = new Date(firstDay.getTime() - 3 * 24 * 60 * 60 * 1000).toLocaleDateString();
                var day5 = new Date(firstDay.getTime() - 4 * 24 * 60 * 60 * 1000).toLocaleDateString();
                var day6 = new Date(firstDay.getTime() - 5 * 24 * 60 * 60 * 1000).toLocaleDateString();;
                var day7 = new Date(firstDay.getTime() - 6 * 24 * 60 * 60 * 1000).toLocaleDateString();
                var days = [day1, day2, day3, day4, day5, day6, day7];
                var firstdata = this.graph1;

                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: days,
                        datasets: [{
                            label: 'Заказов за день',
                            data: this.graph1,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderWidth: 1
                        }]
                    },
                });

                var myChart2 = new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: days,
                        datasets: [{
                            label: 'Заявок за день',
                            data: this.graph2,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderWidth: 1
                        }]
                    },
                });
            }
        },
    });
</script>


<style>

    .graph{
        display: block;
        width: 40vw;
        margin-bottom: 20px;
        padding: 20px;
    }

    h1{
        display: block;
        width: 100%;
        padding-left: 25px;
        border-bottom: 1px solid #0a3d62;
    }

    .blocks{
        padding: 20px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        width: 100%;
    }

    .iteminfo{
        flex: 0 0 15%;
        max-width: 15%;
        -ms-flex: 0 0 15%;
        border-radius: 15px;
        background: #4a69bd;
        display: flex;
        flex-direction: column;
        padding: 15px;
        margin-bottom: 20px;
        position: relative;
        height: 20vh
    }

    .iteminfo:nth-child(2){
        background: #e58e26;
    }
    .iteminfo:nth-child(3){
        background: #b71540;
    }
    .iteminfo:nth-child(4){
        background: #0c2461;
    }
    .iteminfo:nth-child(5){
        background: #0a3d62;
    }
    .iteminfo:nth-child(6){
        background: #079992;
    }

    .iteminfo p{
        font-size: 14px;
        font-weight: 100;
        color: #fff;
        margin: 0;
        padding: 0;
    }

    .iteminfo span{
        font-size: 30px;
        line-height: 30px;
        font-weight: 700;
        color: #fff;
        margin: 0;
        padding: 0;
    }

    .iteminfo svg{
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
    }

    .graphs{
        width: 100%;
        display: flex;
        justify-content: space-between;
    }

    .itemstosale{
        display: flex;
        width: 100%;
        padding: 0 25px;
        justify-content: space-between;
    }

    .itemstosale .product{
        display: flex;
        flex-direction: column;
        flex: 0 0 18%;
        -ms-flex: 0 0 18%;
        max-width: 18%;
    }

    .itemstosale .product a:nth-child(2){
        font-size: 16px;
        line-height: 30px;
        font-weight: bold;
    }

    .itemstosale .product a{
        display: flex;
        flex-wrap: wrap;
        color: #000;
        font-weight: 400;
    }


</style>