<template>
    <tr class="w-full border border-black divide-x-2 divide-black xl:text-xl md:text-lg text-sm">
        <td class="lg:pl-3 pl-1 py-2 w-2/12">{{ product.code }}</td>
        <td class="lg:pl-3 pl-1 py-2 w-7/12">{{ product.title }}</td>
        <td class="lg:pl-3 pl-1 py-2 w-2/12">{{ product.price }}</td>
        <td v-if="! isDeleted" class="lg:pl-3 pl-1 py-2 w-1/12">
            <div class="w-full flex justify-start lg:gap-6 gap-1">
                <router-link :to="'/products/edit/' + product.id" class="hover:underline">Edit</router-link>
                <button class="hover:underline" @click="remove()">Remove</button>
            </div>
        </td>

        <td v-if="isDeleted" class="lg:pl-3 pl-1 py-2 w-1/12">
            <div class="w-full flex justify-start lg:gap-6 gap-1">
                <button class="hover:underline" @click="restore()">Restore</button>
            </div>
        </td>
    </tr>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        product: {
            type: Object,
            required: true,
            default: () => {}
        },
        isDeleted: {
            type: Boolean,
            required: true,
            default: false
        }
    },
    methods: {
        async remove() {
            await axios.delete(`/api/products/${this.product.id}`, { headers: this.headers})
                .then(response => {
                    if(response) {
                        this.$router.go(this.$router.currentRoute)
                    } 
                })
                .catch(error => console.log(error));
        }, 
        
        async restore() {
            await axios.get(`/api/products/restore/${this.product.id}`, { headers: this.headers})
                .then(response => {
                    if(response) {
                        this.$router.go(this.$router.currentRoute)
                    } 
                })
                .catch(error => console.log(error));
        },
    },
    data() {
        return {
            headers: {
                "Authorization": 'Bearer ' + localStorage.getItem('jwt_token')
            }
        }
    }
}
</script>
