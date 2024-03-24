<template>
    <page-template title="All products">
        <section id="all-products" class="w-full min-h-[40vh] flex flex-col justify-center items-center">
            <div class="lg:w-10/12 w-full flex flex-row justify-start items-center lg:h-16 h-10 gap-4">
                <div v-if="deletedProducts.length > 0">
                    <button v-if="! showDeletedTable" @click="showDeletedTable = !showDeletedTable" class="button-primary px-10 mb-4">Deleted products</button>
                    <button v-if="showDeletedTable" @click="showDeletedTable = !showDeletedTable" class="button-primary px-10 mb-4">Active products</button>
                </div>

                <div>
                    <router-link to="/products/create" class="button-primary px-10 mb-4">New product</router-link>
                </div>
            </div>

            <div v-if="!showDeletedTable" class="lg:w-10/12 w-full lg:px-0 px-2 h-full flex justify-center items-center">
                <products-items-table :products="products"></products-items-table>
            </div>

            <div v-if="showDeletedTable && deletedProducts.length > 0" class="lg:w-10/12 w-full lg:px-0 px-2 h-full flex justify-center items-center">
                <products-items-table :products="deletedProducts" :is-deleted="true"></products-items-table>
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
        this.getDeleteProducts()
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
        async getDeleteProducts() {
            await axios.get("/api/products/deleted", { headers: this.headers })
            .then(response => {
                    this.deletedProducts = response.data;
                })
            .catch(error => console.log(error));
        },
    },
    data() {
        return {
            products: [],
            deletedProducts: [],
            showDeletedTable: false,
            headers: { 
                "Authorization": 'Bearer ' + localStorage.getItem('jwt_token') 
            }
        }
    }
}
</script>
