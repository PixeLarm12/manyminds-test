<template>
    <page-template title="All products">
        <section id="all-products" class="w-full min-h-[40vh] flex flex-col justify-center items-center">
            <div class="lg:w-10/12 w-full lg:px-0 px-2 lg:h-12 h-10">
                <router-link to="/products/create" class="lg:px-10 lg:py-4 px-6 py-2 rounded-md bg-light-black text-white lg:text-xl text-lg font-bold">New product</router-link>
            </div>

            <div class="lg:w-10/12 w-full lg:px-0 px-2 h-full flex justify-center items-center">
                <products-items-table :products="products"></products-items-table>
            </div>
        </section>
    </page-template>
</template>

<script>
import axios from 'axios';
import PageTemplate from "../../Components/PageTemplate.vue"
import ProductsItemsTable from '../../Components/Products/ProductsItemsTable.vue'

export default {
    beforeMount() {
        this.getProducts()
    },
    components: {
        PageTemplate,
        ProductsItemsTable
    },
    methods: {
        async getProducts() {
            await axios.get("/api/products", { headers: this.headers })
            .then(response => {
                    this.products = response.data;
                })
            .catch(error => console.log(error));
        },
    },
    data() {
        return {
            products: [],
            headers: { 
                "Authorization": 'Bearer ' + localStorage.getItem('jwt_token') 
            }
        }
    }
}
</script>
