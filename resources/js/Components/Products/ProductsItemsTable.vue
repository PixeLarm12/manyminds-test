<template>
    <table class="w-full bg-gray-50">
        <tr class="w-full text-left border border-black divide-x-2 divide-black">
            <th class="lg:pl-3 pl-1 py-3 xl:text-xl md:text-lg text-sm font-bold text-white bg-light-black">Code</th>
            <th class="lg:pl-3 pl-1 py-3 xl:text-xl md:text-lg text-sm font-bold text-white bg-light-black">Title</th>
            <th class="lg:pl-3 pl-1 py-3 xl:text-xl md:text-lg text-sm font-bold text-white bg-light-black">Price</th>
            <th class="lg:pl-3 pl-1 py-3 xl:text-xl md:text-lg text-sm font-bold text-white bg-light-black">Actions</th>
        </tr>

        <products-item-row v-for="(product, index) in products" :key="index" :product="product"></products-item-row>
    </table>
</template>

<script>
import ProductsItemRow from "./ProductsItemRow.vue"

export default {
    components: {
        ProductsItemRow
    },
    props: {
        products: {
            type: Array,
            required: true,
            default: () => []
        }
    }
}
</script>
