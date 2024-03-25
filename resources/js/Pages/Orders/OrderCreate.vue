<template>
    <page-template :title="getPageTitle">
        <div class="w-screen min-h-[70vh] flex flex-col justify-center items-center">
            <div class="w-6/12 min-h-[40vh] bg-light-black flex flex-col justify-center items-center rounded-lg shadow-lg my-10 py-5">
                <h1 class="w-full text-center text-white text-4xl font-bold">{{ getPageTitle }}</h1>

                <form @submit.prevent="submitForm()" method="POST" class="xl:w-8/12 h-full px-4 grid grid-cols-12 gap-6 place-items-center place-content-center">
                    <div class="md:col-span-6 col-span-12 w-full">
                        <label for="supplier_id" class="text-white text-2xl font-semibold">Select supplier <span class="font-bold text-red-600 text-xl">*</span></label><br>
                        <select id="supplier_id" v-model="order.supplier_id" name="supplier_id" class="w-full h-10 px-5 rounded-md border border-black border-opacity-80" required>
                            <option value="" selected>Selected the supplier</option>
                            <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">{{ supplier.name }}</option>
                        </select>
                    </div>
                    
                    <div class="md:col-span-6 col-span-12 w-full">
                        <label for="products" class="text-white text-2xl font-semibold">Select products <span class="font-bold text-red-600 text-xl">*</span></label><br>
                        <select id="products" v-model="selectedProduct" name="products" class="w-full h-10 px-5 rounded-md border border-black border-opacity-80" required>
                            <option value="" selected>Select products</option>
                            <option v-for="product in productsOptions" :key="product.id" :value="product">{{ product.title }}</option>
                        </select>
                    </div>

                    <div class="col-span-12 w-full">
                        <label for="observation" class="text-white text-2xl font-semibold">Observation (optional)</label><br>
                        <textarea v-model="order.observation" class="w-full h-10 px-5 rounded-md border border-black border-opacity-80 resize-none" placeholder="Add observation"></textarea>
                    </div>
                    
                    <div class="col-span-12 w-full">
                        <span class="text-red-500 text-lg">{{ errors.supplier }}</span>
                        <span class="text-red-500 text-lg">{{ errors.products }}</span>
                        <span class="text-red-500 text-lg self-center w-10/12 py-5">{{ errors.save }}</span>
                    </div>

                    <div class="col-span-12 w-full">
                        <table class="w-full">
                            <tr class="w-full border border-black divide-x-2 divide-black">
                                <th class="bg-gray-400 text-black font-bold text-lg">Title</th>
                                <th class="bg-gray-400 text-black font-bold text-lg">Amount</th>
                                <th class="bg-gray-400 text-black font-bold text-lg">Unit. Price</th>
                                <th class="bg-gray-400 text-black font-bold text-lg">Total</th>
                                <th class="bg-gray-400 text-black font-bold text-lg"> - </th>
                            </tr>

                            <tr v-for="item in selectedProducts" :key="item.id" class="w-full bg-white border border-black divide-x-2 divide-black">
                                <th class="text-black text-lg w-5/12">{{ item.title }}</th>
                                <th class="text-black text-lg w-2/12">
                                    <input type="number" step="1" min="0" v-model="item.amount"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="w-full">
                                </th>
                                <th class="text-black text-lg w-2/12">{{ item.price }}</th>
                                <th class="text-black text-lg w-2/12">{{ getTotalPrice(item) }}</th>
                                <th class="text-black text-lg w-1/12"><span @click="removeItem(item)" class="text-xl font-bold text-black hover:underline hover:cursor-pointer">X</span></th>
                            </tr>
                        </table>
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
            productsOptions: [],
            suppliers: [],
            selectedProduct: {},
            selectedProducts: [],
            order: {
                id: '',
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
    watch: {
        selectedProduct(newVal, oldVal) {
            if(newVal) {
                this.selectedProducts.push(newVal);
                newVal = {};
            }
        },
    },
    methods: {
        submitForm() {
            this.validateForm();

            if(this.order.id) {
                this.update();
            } else {
                this.save();
            }
        },
        async getProducts() {
            await axios.get(`/api/products`, { headers: {"Authorization": 'Bearer ' + localStorage.getItem('jwt_token')} })
                .then(response => {
                    if(response.data) {
                        this.productsOptions = response.data;
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
                        this.order.id = response.data.order.id;
                        this.order.supplier_id = response.data.order.supplier_id;
                        this.order.observation = response.data.order.observation;
                        let products = [];

                        response.data.products.forEach(product => {
                            products.push({
                                "id": product.id,
                                "title": product.title,
                                "price": product.price,
                                "code": product.code,
                                "amount": product.pivot.amount,
                                "totalItemPrice": product.pivot.total_price,
                            });
                        });

                        this.selectedProducts = products;
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
                        this.$router.push('/orders')
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
                `/api/orders/${this.order.id}`, data, { headers: this.headers })
                .then(response => {
                   if(! response.data) {
                        this.errors.save = "An error occurred when trying to UPDATE new Order. Try again later.";
                    } else {
                        this.$router.push('/orders')
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
        },
        getTotalPrice(item) {
            if(! item.price || ! item.amount) {
                return (0.00).toFixed(2);
            }
            
            item.totalItemPrice = (item.price * item.amount).toFixed(2);
            
            return item.totalItemPrice;
        },
        removeItem(item) {
            this.selectedProducts.shift(item);
        }
    },
}
</script>
