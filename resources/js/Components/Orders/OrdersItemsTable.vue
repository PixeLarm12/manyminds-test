<template>
    <table class="w-full bg-gray-50">
        <tr class="w-full text-left border border-black divide-x-2 divide-black">
            <th class="lg:pl-3 pl-1 py-3 xl:text-xl md:text-lg text-sm font-bold text-white bg-light-black">ID</th>
            <th class="lg:pl-3 pl-1 py-3 xl:text-xl md:text-lg text-sm font-bold text-white bg-light-black">Supplier</th>
            <th class="lg:pl-3 pl-1 py-3 xl:text-xl md:text-lg text-sm font-bold text-white bg-light-black">Total value</th>
            <th v-if="!isFinished" class="lg:pl-3 pl-1 py-3 xl:text-xl md:text-lg text-sm font-bold text-white bg-light-black">Actions</th>
        </tr>

        <orders-item-row v-for="(order, index) in orders" :key="index" :order="order" :is-finished="isFinished"></orders-item-row>
    </table>
</template>

<script>
import OrdersItemRow from "./OrdersItemRow.vue"

export default {
    components: {
        OrdersItemRow
    },
    props: {
        orders: {
            type: Array,
            required: true,
            default: () => []
        },
        isFinished: {
            type: Boolean,
            required: true,
            default: false
        }
    }
}
</script>
