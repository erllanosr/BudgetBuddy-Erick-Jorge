<template>
    <form @submit.prevent="submitTransferencia" method="post" class="shadow-xl bg-[#d8eefe] rounded-xl h-auto p-10 pt-5">
        <h1 class="font-bold text-2xl">Realizar Transferencia</h1>
        <label for="cb_origen_id">Cuenta Bancaria Origen</label>
        <!-- <TextInput type="text" class="mt-1 block w-full" v-model="cb_origen_id" /> -->
        <select id="tipo_cuenta" v-model="cuenta_bancaria_id" placeholder="Elige tu cuenta"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            required>
            <option v-for="cuenta in cuentas" :value="cuenta.id">{{ cuenta.id }} - {{ cuenta.numero_cuenta }}</option>
        </select>
        <label for="monto">Monto</label>
        <TextInput id="monto" v-model="monto" type="number" step="0.01" class="mt-1 block w-full" />

        <label for="descripcion">Descripción</label>
        <TextInput id="descripcion" v-model="descripcion" type="text" class="mt-1 block w-full" />

        <label for="fecha">Fecha</label>
        <TextInput id="fecha" v-model="fecha" type="date" class="mt-1 block w-full" />

        <label for="titular_cb_destino">Titular Destinatario</label>
        <TextInput type="text" v-model="titular_cb_destino" class="mt-1 block w-full"/>
        <label for="numero_cb_destino">Cuenta Bancaria Destino</label>
        <TextInput id="numero_cb_destino" v-model="numero_cb_destino" type="text" class="mt-1 block w-full"
            placeholder="ES##..." v-maska data-maska="ES##-####-####-##-##########" />
        <div class="flex mt-4 file:gap-2 text-right">
            <Boton>Aceptar</Boton>
        </div>
    </form>
</template>
<script setup>
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Boton from '../Boton.vue';
import { vMaska } from 'maska';
</script>
<script>
import axios from 'axios';
// import {route} from '@inertiajs/vue3'

export default {
    data() {
        return {
            cuenta_bancaria_id: "",
            numero_cb_destino: "",
            monto: "",
            descripcion: "",
            fecha: "",
            titular_cb_destino: "",
            cuentas: [],
        };
    },
    methods: {
        submitTransferencia() {
            axios
                .post(route("transaccion.transferir"), {
                    // Datos de la transferencia
                    cb_origen_id: this.cuenta_bancaria_id,
                    numero_cb_destino: this.numero_cb_destino,
                    monto: this.monto,
                    descripcion: this.descripcion,
                    fecha: this.fecha,
                    titular_cb_destino: this.titular_cb_destino,
                })
                .then(response => {
                    if (response.data && response.data.status === "success") {
                        alert("Transferencia realizada con éxito");
                        window.location.href = "/transacciones";
                    }
                    else if (response.data && response.data.message) {
                        alert(response.data.message);
                    }
                    else {
                        alert("Error al realizar la transferencia desde el componente.");
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert("Error al realizar la transferencia desde el componente.");
                });
        },

    },
    created() {
        axios.get('/cuentas-json')
            .then(response => {
                this.cuentas = response.data;
            })
            .catch(error => {
                console.log(error);
            });
    },
    components: { TextInput }
};
</script>
