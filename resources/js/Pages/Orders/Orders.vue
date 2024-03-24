<template>
    <default-header></default-header>
    
    <page-template title="All orders">
        <section id="all-orders" class="w-full min-h-[40vh] flex flex-col justify-center items-center">
            <div class="lg:w-10/12 w-full flex flex-row justify-start items-center lg:h-16 h-10 gap-4">
                <div>
                    <router-link to="/orders/create" class="button-primary px-10 mb-4">New order</router-link>
                </div>
            </div>
        </section>
    </page-template>
</template>

<script>
import axios from 'axios';
import PageTemplate from "../../Components/PageTemplate.vue"
import DefaultHeader from '../../Components/DefaultHeader.vue';

export default {
    beforeMount() {
        if(! localStorage.getItem('jwt_token')) {
            this.$router.go('/login')
        }

        this.getOrders()
    },
    components: {
        PageTemplate,
        DefaultHeader
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
            headers: { 
                "Authorization": 'Bearer ' + localStorage.getItem('jwt_token') 
            }
        }
    }
}
</script>
