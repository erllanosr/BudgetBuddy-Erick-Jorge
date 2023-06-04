<template>
        <!-- Content area -->
        <div class="flex flex-col flex-1">
            <main>
                <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
                    <h1 class="font-bold text-4xl pb-2 text-black">GASTOS</h1>
                    <!-- Page header -->
                    <div class="sm:flex sm:justify-between sm:items-center mb-4 md:mb-2">

                        <!-- Left: Title -->
                        <div class="mb-4 sm:mb-0">
                            <h2 class="text-2xl md:text-3xl text-red-500 font-bold"><span class="text-black">Has gastado
                                </span>{{ sumaTotal }} €</h2>
                        </div>

                        <!-- Right: Actions  -->
                        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                            <div class="hidden sm:block">
                                <SearchForm class="hidden sm:block" />
                            </div>
                            <!-- <button class="btn bg-[#3da9fc] hover:bg-[#3da9fc] text-white" @click="exportarPDF">Exportar Gastos</button> -->
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <Boton type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md focus:outline-none transition ease-in-out duration-150">
                                            EXPORTAR
                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </Boton>
                                    </span>
                                </template>
                                <template #content>
                                    <DropdownLink @click="exportarPDF">PDF</DropdownLink>
                                    <DropdownLink @click="exportarExcel">
                                        Excel
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                    <div class="mb-5">
                        <span>Transacciones desde mi </span>
                        <DropdownTransaction />
                    </div>
                    <!-- Table -->
                    <div class="overflow-auto max-h-[500px]">
                        <GastoTodosVue></GastoTodosVue>
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
import { ref } from 'vue'
import Header from '../../../Components/mosaic/partials/Header.vue'

import SearchForm from '../../../Components/mosaic/components/SearchForm.vue';
import DropdownTransaction from '../../../Components/mosaic/components/DropdownTransaction.vue'

import PaginationClassic from '../../../Components/mosaic/components/PaginationClassic.vue'
import GastoTodosVue from './GastoTodos.vue';
import Dropdown from '../../Dropdown.vue';
import DropdownLink from '../../DropdownLink.vue';
import Boton from '../Boton.vue';
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
        this.obtenerSumaTotalGastos();
    },
    methods: {
        obtenerSumaTotalGastos() {
            axios.get('/total-gastos-json')
                .then(response => {
                    this.sumaTotal = response.data.suma_total;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        exportarPDF() {
            window.open('/gastos-pdf', '_blank');
        },
        exportarExcel() {
            window.open('/gastos-excel', '_blank');
        }
    }
};
</script>
