<template>
    <page-template :title="getPageTitle">
        <div class="w-screen min-h-[70vh] flex flex-col justify-center items-center">
            <div class="w-6/12 min-h-[40vh] bg-light-black flex flex-col justify-center items-center rounded-lg shadow-lg my-10 py-3">
                <h1 class="w-full text-center text-white text-4xl font-bold">{{ getPageTitle }}</h1>

                <form @submit.prevent="submitForm()" method="POST" class="xl:w-6/12 h-full px-4 grid grid-cols-12 gap-6 place-items-center place-content-center">
                    <div class="md:col-span-6 col-span-12 w-full">
                        <label for="supplier_id" class="text-white text-2xl font-semibold">Select supplier <span class="font-bold text-red-600 text-xl">*</span></label><br>
                        <select id="supplier_id" v-model="order.supplier_id" name="supplier_id" class="w-full h-10 px-5 rounded-md border border-black border-opacity-80" required>
                            <option value="" selected>Selected the supplier</option>
                            <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">{{ supplier.name }}</option>
                        </select>
                    </div>
                    
                    <div class="md:col-span-6 col-span-12 w-full">
                        <label for="products" class="text-white text-2xl font-semibold">Select products <span class="font-bold text-red-600 text-xl">*</span></label><br>
                        <select id="products" v-model="selectedProducts" name="products" class="w-full h-10 px-5 rounded-md border border-black border-opacity-80" required>
                            <option value="" selected>Select products to add in this order</option>
                            <option v-for="product in products" :key="product.id" :value="product.id">{{ product.title }}</option>
                        </select>
                    </div>

                    <div class="col-span-12 w-full">
                        <label for="observation" class="text-white text-2xl font-semibold">Observation (optional)</label><br>
                        <textarea v-model="order.observation" class="w-full h-10 px-5 rounded-md border border-black border-opacity-80 resize-none" placeholder="Add observation"></textarea>
                    </div>
                    
                    <div class="w-full col-span-12">
                        <span class="text-red-500 text-lg">{{ errors.supplier }}</span>
                        <span class="text-red-500 text-lg">{{ errors.products }}</span>
                        <span class="text-red-500 text-lg self-center w-10/12 py-5">{{ errors.save }}</span>
                    </div>
                    
                    <div class="col-span-12 w-8/12 flex justify-center items-center pt-12">
                        <button type="submit" name="submitButton" id="submitButton" class="button-secondary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </page-template>
</template>

<script>
import axios from 'axios';
import PageTemplate from '../../Components/PageTemplate.vue';

export default {
    beforeMount() {
        if(! localStorage.getItem('jwt_token')) {
            this.$router.push("/login");
        }

        this.getProducts();
        this.getSuppliers();

        if(this.$route.params.id) {
            this.getOrder();
        }
    },
    components: {
        PageTemplate
    },
    data() {
        return {
            products: [],
            suppliers: [],
            selectedProducts: [],
            order: {
                supplier_id: '',
                observation: '',
            },
            errors: {
                supplier: "",
                products: "",
            },
            headers: {
                "Authorization": 'Bearer ' + localStorage.getItem('jwt_token'),
            },
        }
    },
    computed: {
        getPageTitle() {
            return this.order.id ? `Edit Order #${this.order.id}` : 'Create Order';
        },
    },
    methods: {
        submitForm() {
            this.validateForm();

            if(this.$route.params.id) {
                this.update();
            } else {
                this.save();
            }
        },
        async getProducts() {
            await axios.get(`/api/products`, { headers: {"Authorization": 'Bearer ' + localStorage.getItem('jwt_token')} })
                .then(response => {
                    if(response.data) {
                        this.products = response.data;
                    }
                })
                .catch(error => console.log(error));
        },
        async getSuppliers() {
            await axios.get(`/api/suppliers`, { headers: {"Authorization": 'Bearer ' + localStorage.getItem('jwt_token')} })
                .then(response => {
                    if(response.data) {
                        this.suppliers = response.data;
                    }
                })
                .catch(error => console.log(error));
        },
        async getOrder() {
            await axios.get(`/api/orders/${this.$route.params.id}`, { headers: {"Authorization": 'Bearer ' + localStorage.getItem('jwt_token')} })
                .then(response => {
                    if(response.data) {
                        this.order.id = response.data.id;
                        this.order.supplier_id = response.data.supplier_id;
                        this.order.observation = response.data.observation;
                        this.selectedProducts = response.data.products;
                    }
                })
                .catch(error => console.log(error));
        },
        async save() {
            const data = {
                    "supplier_id": this.order.supplier_id,
                    "observation": this.order.observation,
                    "products": this.selectedProducts,
            };
            await axios.post(
                "/api/orders", data, { headers: this.headers })
                .then(response => {
                    if(! response.data) {
                        this.errors.save = "An error occurred when trying to SAVE new Order. Try again later.";
                    } else {
                        this.$router.push('/')
                    } 
                })
                .catch(error => console.log(error));
        },
        async update() {
            const data = {
                "supplier_id": this.order.supplier_id,
                "observation": this.order.observation,
                "products": this.selectedProducts
            }
            await axios.post(
                `/api/orders/${this.product.id}`, data, { headers: this.headers })
                .then(response => {
                   if(! response.data) {
                        this.errors.save = "An error occurred when trying to UPDATE new Order. Try again later.";
                    } else {
                        this.$router.push('/')
                    } 
                })
                .catch(error => console.log(error));
        },
        validateForm() {
            let shouldSubmit = true;

            if(this.order.supplier_id === '') {
                this.errors.supplier = "The Supplier field is required!";
                shouldSubmit = false;
            }

            if(this.selectedProducts.length < 1) {
                this.errors.products = "Add at least one product to order!";
                shouldSubmit = false;
            }

            return shouldSubmit
        }
    },
}
</script>
