<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Boton from '../Boton.vue';

const form = useForm({
    descripcion: '',
    monto: '',
    fecha: '',

});

const resetForm = () => {
    form.descripcion = '';
    form.monto = '';
    form.fecha = '';

};
const submit = () => {
    form.post(route('gastos.store'));
};
</script>
<template>
    <form @submit.prevent="submit" method="post">
        <div class="p-10 pt-5 bg-[#d8eefe] rounded-xl shadow-2xl">
            <h2 class="font-bold text-2xl">Agrega un gasto</h2>

            <InputLabel for="descripcion" value="Descripcion" />
            <TextInput id="descripcion" v-model="form.descripcion" type="text" class="mt-1 block w-full"
                placeholder="Descripcion" />
            <InputLabel for="monto" value="Saldo" />
            <TextInput id="monto" v-model="form.monto" type="text" class="mt-1 block w-full" placeholder="€"
                maxlength="16" />
            <InputLabel for="fecha" value="Fecha"/>
            <TextInput id="fecha" v-model="form.fecha" type="date" class="mt-1 block w-full" />
            <div class="flex mt-4 file:gap-2 text-right">
                <Boton type="submit">Aceptar</Boton>
            </div>
        </div>
    </form>
</template>
