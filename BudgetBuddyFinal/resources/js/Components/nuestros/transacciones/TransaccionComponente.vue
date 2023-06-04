<template>
    <tr>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm font-medium text-gray-900">{{ transaccion.cb_origen_id }}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm font-medium text-gray-900">{{ transaccion.descripcion }}</div>
        </td>

        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm font-medium text-gray-900">{{ transaccion.monto }}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm font-medium text-gray-900">{{ transaccion.titular_cb_destino }}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm font-medium text-gray-900">{{ truncatedNumero }}</div>
        </td>
    </tr>
</template>
<script>
export default {
    props: {
        transaccion: {
            type: Object,
            required: true
        }
    },
    computed: {
        truncatedNumero() {
            const numero = this.transaccion.numero_cb_destino;
            // Obtener los últimos cuatro dígitos del número de tarjeta
            const ultimosCuatroDigitos = numero.slice(-4);
            // Generar una versión truncada del número de tarjeta con asteriscos para ocultar los dígitos restantes
            const numeroTruncado = '****-****-****-' + ultimosCuatroDigitos;
            return numeroTruncado;
        }
    }
}
</script>
