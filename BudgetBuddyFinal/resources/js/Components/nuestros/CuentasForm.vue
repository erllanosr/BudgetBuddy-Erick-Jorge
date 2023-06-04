<script setup>
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { vMaska } from 'maska';
import { ref } from 'vue';
import Boton from './Boton.vue';

const confirmingCardAddition = ref(false);
const form = useForm({
    nombre_titular: '',
    banco: '',
    tipo_cuenta: '',
    numero_cuenta: '',
    monto: '',
});

const confirmCardAddition = () => {
    confirmingCardAddition.value = true;
};

const resetForm = () => {
    form.descripcion = '';
    form.monto = '';
    form.fecha = '';
};
const submit = () => {
    form.post(route('guardar-datos'));
};
</script>
<template>
    <form @submit.prevent="submit" class="shadow-xl bg-[#d8eefe] rounded-xl h-auto p-10 pt-5">
        <h1 class="font-bold text-2xl">Agrega una cuenta bancaria</h1>
        <label for="text">Nombre y Apellido</label>
        <TextInput id="nombre_titular" type="text" class="mt-1 block w-full" v-model="form.nombre_titular" required
            placeholder="John Doe" />
        <label for="banco">Elige tu banco:</label>
        <select id="banco" v-model="form.banco"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            required>
            <option selected>Elige una opción</option>
            <option value="SANTANDER">Santander</option>
            <option value="CAIXABANK">Caixabank</option>
            <option value="BBVA">BBVA</option>
            <option value="OPENBANK">Openbank</option>
            <option value="SABADELL">Sabadell</option>
            <option value="ING">ING</option>
        </select>
        <label for="tipo_cuenta">Elige tu tipo de cuenta:</label>
        <select id="tipo_cuenta" v-model="form.tipo_cuenta"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            required>
            <option selected>Elige una opción</option>
            <option value="CORRIENTE">Cuenta corriente</option>
            <option value="AHORRO">Cuenta ahorro</option>
        </select>
        <label for="numero_cuenta">Ingresa tu número de cuenta:</label>
        <TextInput id="numero_cuenta" type="text" class="mt-1 block w-full" v-model="form.numero_cuenta" required v-maska placeholder="ES##..."
            data-maska="ES##-####-####-##-##########"/>
        <label for="monto">Ingresa el saldo de tu cuenta (solo para demo):</label>
        <TextInput id="monto" type="number" class="mt-1 block w-full" v-model="form.monto" required placeholder="40.000€" v-maska="'#*.##'" />
        <div class="flex mt-4 file:gap-2 text-right">
            <Boton>Aceptar</Boton>
        </div>
    </form>
</template>
