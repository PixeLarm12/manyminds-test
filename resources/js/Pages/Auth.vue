<template>
    <div class="w-screen min-h-[100vh] flex flex-col justify-center items-center bg-light-black">
        <div class="xl:w-4/12 w-11/12 min-h-[40vh] bg-gray-100 flex flex-col justify-center items-center rounded-lg shadow-lg py-10">
            <h1 class="xl:text-6xl text-4xl text-black font-semibold uppercase py-4">Login</h1>
            <span class="text-red-600 text-lg self-center w-10/12 py-5">{{ errors.auth }}</span>
            <form @submit.prevent="submitForm()" method="POST" class="w-full h-full px-4 grid grid-cols-12 gap-6 place-items-center place-content-center">
                <div class="col-span-12 xl:w-8/12 w-10/12">
                    <label for="email" class="text-black xl:text-2xl text-xl font-semibold">E-mail</label><br>
                    <input type="email" id="email" v-model="email" name="email" placeholder="Digite o seu email" class="w-full h-10 px-5 rounded-md border border-black border-opacity-80" required>
                    <span class="text-red-600 text-lg">{{ errors.email }}</span>
                </div>

                <div class="col-span-12 xl:w-8/12 w-10/12">
                    <label for="password" class="text-black xl:text-2xl text-xl font-semibold">Password</label><br>
                    <input type="password" id="password" v-model="password" name="password" placeholder="Digite a sua senha" class="w-full h-10 px-5 rounded-md border border-black border-opacity-80" required>
                    <span class="text-red-600 text-lg">{{ errors.password }}</span>
                </div>

                <div class="col-span-12 xl:w-8/12 w-10/12 flex justify-center items-center">
                    <button type="submit" name="submitButton" id="submitButton" class="button-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            email: '',
            password: '',
            errors: {
                email: "",
                password: "",
                auth: ""
            }
        }
    },
    methods: {
        async submitForm() {
            if(this.validation) {
                await axios.post(
                    "/api/login", {
                        'email': this.email,
                        'password': this.password,
                    })
                    .then(response => {
                        localStorage.setItem('jwt_token', response.data.access_token);

                        this.$router.push('/') 
                    })
                    .catch(error => {
                        this.errors.auth = "A login error occurred. Please verify your credentials.";
                        console.log(error)
                    });
            }
        },
        validation() {
            let shouldSubmit = true;

            if(this.email === '') {
                this.errors.email = "The Email field is required!";
                shouldSubmit = false;
            }

            if(this.password === '') {
                this.errors.password = "The Password field is required!";
                shouldSubmit = false;
            }

            return shouldSubmit
        },
    }
}
</script>