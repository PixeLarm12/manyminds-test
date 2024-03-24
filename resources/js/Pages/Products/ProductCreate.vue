<template>
    <page-template :title="getPageTitle">
        <div class="w-screen min-h-[70vh] flex flex-col justify-center items-center">
            <div class="w-6/12 min-h-[40vh] bg-light-black flex flex-col justify-center items-center rounded-lg shadow-lg my-10 py-3">
                <h1 class="w-full text-center text-white text-4xl font-bold">{{ getPageTitle }}</h1>

                <form @submit.prevent="submitForm()" method="POST" class="xl:w-6/12 h-full px-4 grid grid-cols-12 gap-6 place-items-center place-content-center">
                    <div class="col-span-12 w-full">
                        <label for="title" class="text-white text-2xl font-semibold">Product's Title <span class="font-bold text-red-600 text-xl">*</span></label><br>
                        <input type="text" id="title" v-model="product.title" name="title" placeholder="Type the product's title" class="w-full h-10 px-5 rounded-md border border-black border-opacity-80" required>
                    </div>
                    
                    <div class="md:col-span-6 col-span-12 w-full">
                        <label for="title" class="text-white text-2xl font-semibold">Product's Code <span class="font-bold text-red-600 text-xl">*</span></label><br>
                        <input type="text" id="code" v-model="product.code" name="code" placeholder="Type the product's code" class="w-full h-10 px-5 rounded-md border border-black border-opacity-80" required>
                    </div>

                    <div class="md:col-span-6 col-span-12 w-full">
                        <label for="price" class="text-white text-2xl font-semibold">Product's Price ($) <span class="font-bold text-red-600 text-xl">*</span></label><br>
                        <input type="number" step=".01" id="price" v-model="product.price" name="price" placeholder="Type the product's price" class="w-full h-10 px-5 rounded-md border border-black border-opacity-80" required>
                    </div>
                    
                    <div class="w-full col-span-12">
                        <span class="text-red-500 text-lg">{{ errors.price }}</span>
                        <span class="text-red-500 text-lg">{{ errors.code }}</span>
                        <span class="text-red-500 text-lg">{{ errors.title }}</span>
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

        if(this.$route.params.id) {
            this.getProduct();
        }
    },
    components: {
        PageTemplate
    },
    data() {
        return {
            product: {
                id: "",
                title: "",
                code: "",
                price: "",
            },
            errors: {
                title: "",
                code: "",
                price: "",
            },
            headers: {
                "Authorization": 'Bearer ' + localStorage.getItem('jwt_token'),
            },
        }
    },
    computed: {
        getPageTitle() {
            return this.product.id ? `Edit ${this.product.title}` : 'Create Product';
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
        async getProduct() {
            await axios.get(`/api/products/${this.$route.params.id}`, { headers: {"Authorization": 'Bearer ' + localStorage.getItem('jwt_token')} })
                .then(response => {
                    if(response.data) {
                        this.product.id = response.data.id;
                        this.product.title = response.data.title;
                        this.product.code = response.data.code;
                        this.product.price = response.data.price;
                    }
                })
                .catch(error => console.log(error));
        },
        async save() {
            const data = {
                    "title": this.product.title,
                    "code": this.product.code,
                    "price": this.product.price,
            };
            await axios.post(
                "/api/products", data, { headers: this.headers })
                .then(response => {
                    if(! response.data) {
                        this.errors.save = "An error occurred when trying to SAVE new Product. Try again later.";
                    } else {
                        this.$router.push('/')
                    } 
                })
                .catch(error => console.log(error));
        },
        async update() {
            const data = {
                "id": this.product.id,
                "title": this.product.title,
                "code": this.product.code,
                "price": this.product.price,
            }
            await axios.post(
                `/api/products/${this.product.id}`, data, { headers: this.headers })
                .then(response => {
                   if(! response.data) {
                        this.errors.save = "An error occurred when trying to UPDATE new Product. Try again later.";
                    } else {
                        this.$router.push('/')
                    } 
                })
                .catch(error => console.log(error));
        },
        validateForm() {
            let shouldSubmit = true;

            if(this.product.title === '') {
                this.errors.title = "The Title field is required!";
                shouldSubmit = false;
            }

            if(this.product.code === '' || this.product.code.length < 8) {
                this.errors.code = "The Code field is required and at least 8 numbers!";
                shouldSubmit = false;
            }

            if(this.product.price === '' || this.product.price <= 0.0) {
                this.errors.price = "The price field is required and at least 8 numbers!";
                shouldSubmit = false;
            }

            return shouldSubmit
        }
    },
}
</script>
