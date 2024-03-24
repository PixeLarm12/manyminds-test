<template>
    <page-template title="All orders">
        <section id="all-orders" class="w-full min-h-[40vh] flex flex-col justify-center items-center">
            <div class="lg:w-10/12 w-full flex flex-row justify-start items-center lg:h-16 h-10 gap-4">
                <div v-if="finishedOrders.length > 0">
                    <button v-if="! showFinishedTable" @click="showFinishedTable = !showFinishedTable" class="button-primary px-10 mb-4">Finished orders</button>
                    <button v-if="showFinishedTable" @click="showFinishedTable = !showFinishedTable" class="button-primary px-10 mb-4">Active orders</button>
                </div>

                <div>
                    <router-link to="/orders/create" class="button-primary px-10 mb-4">New order</router-link>
                </div>
            </div>

            <div v-if="orders.length <= 0 && finishedOrders.length <= 0" class="lg:w-10/12 w-full lg:px-0 px-2 h-full flex justify-center items-center">
                <h2 class="text-black text-5xl font-bold">We don't have orders saved yet! Consider adding a new one.</h2>

                <orders-items-table v-if="!showFinishedTable && orders.length > 0" :orders="orders"></orders-items-table>
                
                <orders-items-table v-if="showFinishedTable && finishedOrders.length > 0" :orders="finishedOrders" :is-deleted="true"></orders-items-table>
            </div>
        </section>
    </page-template>
</template>

<script>
import axios from 'axios';
import PageTemplate from "../../Components/PageTemplate.vue"
import OrdersItemsTable from '../../Components/Orders/OrdersItemsTable.vue';

export default {
    beforeMount() {
        if(! localStorage.getItem('jwt_token')) {
            this.$router.go('/login')
        }

        this.getOrders()
    },
    components: {
        PageTemplate,
        OrdersItemsTable
    },
    methods: {
        async getOrders() {
            await axios.get("/api/orders", { headers: this.headers })
            .then(response => {
                    this.orders = response.data;
                })
            .catch(error => console.log(error));
        },
    },
    data() {
        return {
            orders: [],
            finishedOrders: [],
            headers: { 
                "Authorization": 'Bearer ' + localStorage.getItem('jwt_token') 
            }
        }
    }
}
</script>
