<template>
    <div class="flex flex-col col-span-full sm:col-span-12 xl:col-span-4 bg-white rounded-lg border border-sky-500">
      <header class="px-5 py-4 border-b border-slate-100 flex items-center">
        <h2 class="font-semibold text-slate-800">Gastos e Ingresos</h2>
      </header>
      <!-- Chart built with Chart.js 3 -->
      <div class="px-5 py-3">
        <!-- Change the height attribute to adjust the chart height -->
        <canvas ref="pieChart" class="w-full h-full"></canvas>
      </div>
    </div>
  </template>

  <script>
  import axios from 'axios';
  import Chart from 'chart.js/auto';

  export default {
    mounted() {
      this.fetchChartData();
    },
    methods: {
      fetchChartData() {
        axios.get('/pie-chart')
          .then(response => {
            const { gastos, ingresos } = response.data;

            const data = {
              labels: ['Gastos', 'Ingresos'],
              datasets: [{
                data: [gastos, ingresos],
                backgroundColor: ['#FF6384', '#36A2EB'],
              }],
            };

            this.renderChart(data);
          })
          .catch(error => {
            console.error(error);
          });
      },
      renderChart(data) {
        const ctx = this.$refs.pieChart.getContext('2d');

        new Chart(ctx, {
          type: 'pie',
          data: data,
          options: {
            responsive: true,
            maintainAspectRatio: false,
          },
        });
      },
    },
  };
  </script>
