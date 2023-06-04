<template>
    <div class="flex flex-col col-span-full sm:col-span-12 xl:col-span-4 bg-white  rounded-lg border border-sky-500">
        <header class="px-5 py-4 border-b border-slate-100 flex items-center">
            <h2 class="font-semibold text-slate-800">Rentabilidad</h2>
        </header>
        <div class="px-5 py-3">
            <div class="text-sm italic mb-2">Hola {{ $page.props.auth.user.name }}, estás muy cerca de tu objetivo:</div>

        </div>
        <!-- Chart built with Chart.js 3 -->
        <div class="grow">
            <!-- Change the height attribute to adjust the chart height -->
            <canvas id="allChart" class="w-full h-full" data-te-chart="bar"></canvas>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Chart from 'chart.js/auto';


export default {
    name: 'FintechCard07',
    components: {

    },
    data() {
        return {
            ingresosData: [],
            gastosData: [],
        };
    },
    mounted() {
        axios.get('/ingresos-chart-data') // Ruta en tu backend que devuelve los datos de ingresos del gráfico
            .then(response => {
                this.ingresosData = response.data.sort((a, b) => new Date(a.fecha) - new Date(b.fecha));
                this.loadChart();
            })
            .catch(error => {
                console.log(error);
            });

        axios.get('/gastos-chart-data') // Ruta en tu backend que devuelve los datos de gastos del gráfico
            .then(response => {
                this.gastosData = response.data.sort((a, b) => new Date(a.fecha) - new Date(b.fecha));
                this.loadChart();
            })
            .catch(error => {
                console.log(error);
            });
    },
    methods: {
        loadChart() {
            if (this.ingresosData.length > 0 && this.gastosData.length > 0) {
                const ctx = document.getElementById('allChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: this.ingresosData.map(item => item.fecha),
                        datasets: [
                            {
                                label: 'Ingresos',
                                data: this.ingresosData.map(item => item.monto),
                                fill: false,
                                borderColor: 'rgba(59, 130, 246, 1)',
                                backgroundColor: 'rgba(59, 130, 246, 1)',
                                borderWidth: 1,
                            },
                            {
                                label: 'Gastos',
                                data: this.gastosData.map(item => -item.monto),
                                fill: false,
                                borderColor: 'rgba(220, 38, 38, 1)',
                                backgroundColor: 'rgba(220, 38, 38, 1)',
                                borderWidth: 1,
                            },
                        ],
                    },
                    options: {
                        scales: {
                            x: {
                                type: 'time',
                                time: {
                                    unit: 'day',
                                    displayFormats: {
                                        day: 'MMM D',
                                    },
                                },
                                title: {
                                    display: true,
                                    text: 'Fecha',
                                },
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Cantidad',
                                },
                            },
                        },
                    },
                });
            }
        },
    },
};
</script>
<style scoped>
#myChart {
    max-width: 100%;
    height: auto;
}
</style>
