<template>
    <Head title="Transacciones"></Head>
    <AuthenticatedLayout></AuthenticatedLayout>
    <div class="items-center py-2 bg-[#1B3755] text-white">
        <div class="justify-center w-full mx-auto">
            <nav class="flex px-32 mx-auto " aria-label="Breadcrumb">
                <ol role="list" class="flex items-center space-x-4">
                    <li>
                        <div class="flex items-center">
                            <a href="/"
                                class="text-sm font-medium text-white duration-200 hover:text-white hover:scale-110">Dashboard</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>

                            <a href="/transacciones"
                                class="ml-4 text-sm font-medium text-[#d8eefe] duration-200 hover:scale-110 hover:text-white"
                                aria-current="page">Transacciones</a>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="py-8" id="fondo_blur">
        <div class="m-8 grid grid-cols-3 gap-1">
            <div class="col-span-2">
                <TransaccionesTotal/>
            </div>
            <div>
                <TransaccionesForm></TransaccionesForm>
            </div>
        </div>
    </div>
    <Footer></Footer>

</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TransaccionesForm from '../Components/nuestros/transacciones/TransaccionesForm.vue';
import TransaccionesTotal from '../Components/nuestros/transacciones/TransaccionesTotal.vue';
import { Head } from '@inertiajs/vue3';
import Footer from '../Components/Footer.vue';
</script>
<style>
#fondo_blur {
    background-image: linear-gradient(to right top, #d8eefe, #e2f1ff, #ebf3ff, #f3f6ff, #f9faff, #fff);
}
</style>
