<template>
    <div class="flex flex-col col-span-full sm:col-span-12 xl:col-span-4 bg-white rounded-lg border border-sky-500">
    <header class="px-5 py-4 border-b border-slate-100 flex items-center">
      <h2 class="font-semibold text-slate-800">Crecimiento</h2>
    </header>
    <div class="px-5 py-3">
      <div class="text-sm italic mb-2">Hola {{ $page.props.auth.user.name }}, a los 65 podrías tener ahorrados:</div>
      <div class="text-3xl font-bold text-slate-800">2M€ - 3.5M€</div>
      <div class="text-sm text-slate-500">Nivel de riesgo 8</div>
    </div>
    <!-- Chart built with Chart.js 3 -->
    <div class="grow">
      <!-- Change the height attribute to adjust the chart height -->
      <canvas ref="chartCanvas" class="w-full h-full"></canvas>
    </div>
  </div>
  </template>

  <script>
  import axios from 'axios';
  import Chart from 'chart.js/auto';

  export default {
    name: 'CuentaBancariaChart',
    data() {
      return {
        chart: null,
        cuentaData: [],
      };
    },
    mounted() {
      axios
        .get('/cuenta-chart-data') // Ruta en tu backend que devuelve los datos de la cuenta bancaria
        .then(response => {
          this.cuentaData = response.data.sort(
            (a, b) => new Date(a.created_at) - new Date(b.created_at)
          );
          this.loadChart();
        })
        .catch(error => {
          console.log(error);
        });
    },
    methods: {
      loadChart() {
        if (this.cuentaData.length > 0) {
          const ctx = this.$refs.chartCanvas.getContext('2d');
          this.chart = new Chart(ctx, {
            type: 'line',
            data: {
              labels: this.cuentaData.map(item => item.created_at),
              datasets: [
                {
                  label: 'Cuenta bancaria',
                  data: this.cuentaData.map(item => item.monto),
                  fill: false,
                  borderColor: 'rgba(59, 130, 246, 1)',
                  backgroundColor: 'rgba(59, 130, 246, 1)',
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
