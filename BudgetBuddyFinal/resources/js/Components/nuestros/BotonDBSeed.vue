<template>
    <Boton @click="runDatabaseSeeder">IMPORTAR</Boton>
</template>
<script>
import axios from 'axios';

export default {
    methods: {
        runDatabaseSeeder() {
            // Realizar una solicitud HTTP al backend para ejecutar el comando
            axios.post('/db-seed')
                .then(response => {
                    console.log(response.data); // Puedes mostrar el resultado en la consola o hacer algo más con él
                    window.location.reload(); // Recargar la página para ver los cambios
                })
                .catch(error => {
                    console.error(error);
                });
        }
    }
}
</script>
<script setup>
import Boton from './Boton.vue';
</script>
