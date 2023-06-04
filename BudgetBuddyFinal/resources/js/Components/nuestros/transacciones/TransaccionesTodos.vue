<template>
     <table class="min-w-full justify-center">
        <thead class="bg-[#d8eefe]">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                    Núm. Cuenta Origen
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                    Descripción
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                    Cantidad
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                    Titular Cuenta Destino
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                    Núm. Cuenta destino
                </th>
            </tr>
        </thead>
        <tbody v-for="transaccion in transacciones" :key="transaccion.id" class="divide-y divide-gray-200">
            <TransaccionComponente :transaccion="transaccion" />
        </tbody>
    </table>
</template>
<script>
import axios from 'axios';
export default {
    data() {
        return {
            transacciones: [],
        };
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        fetchData(){
            axios.get('/transacciones-json').then(response => {
                this.transacciones = response.data;
            }).catch(error => {
                console.error(error);
            });
        },
    },
}
</script>
<script setup>
import TransaccionComponente from './TransaccionComponente.vue';
</script>
