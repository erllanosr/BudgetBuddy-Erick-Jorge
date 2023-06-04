<template>
    <div class="flex flex-col flex-1">
        <main>
            <div class="px-4 sm:px-6 py-8 w-full max-w-9xl mx-auto">
                <h1 class="font-bold text-4xl pb-2 text-black">CUENTAS BANCARIAS</h1>
                <div class="sm:flex sm:justify-between sm:items-center mb-4 md:mb-2">
                        <!-- Left: Title -->
                        <div class="mb-4 sm:mb-0">
                        </div>
                        <!-- Right: Actions  -->
                        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                            <div class="hidden sm:block">
                                <BotonDBSeed></BotonDBSeed>
                            </div>

                        </div>
                    </div>
                <div>
                    <CuentasBancarias></CuentasBancarias>
                </div>
                <!-- Pagination -->
                <div class="mt-8">
                    <PaginationClassic />
                </div>
            </div>
        </main>

    </div>
</template>

<script setup>

import PaginationClassic from '../../Components/mosaic/components/PaginationClassic.vue';
import CuentasBancarias from './CuentasBancarias.vue';
import BotonDBSeed from './BotonDBSeed.vue';
import Dropdown from '../Dropdown.vue';
import Boton from './Boton.vue';
</script>
<script>
import axios from 'axios';

export default {
    data() {
        return {
            sumaTotal: null
        };
    },
    created() {
        this.obtenerSumaTotalIngresos();
    },
    methods: {
        obtenerSumaTotalIngresos() {
            axios.get('/total-ingresos-json')
                .then(response => {
                    this.sumaTotal = response.data.suma_total;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        exportarPDF() {
            window.open('/ingresos-pdf', '_blank');
        },
        exportarExcel() {
            window.open('/ingresos-excel', '_blank');
        }
    }
};
</script>
