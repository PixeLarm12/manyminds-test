<template>
    <tr class="w-full border border-black divide-x-2 divide-black xl:text-xl md:text-lg text-sm">
        <td class="lg:pl-3 pl-1 py-2 w-2/12">#{{ order.id }}</td>
        <td class="lg:pl-3 pl-1 py-2 w-7/12">{{ order.supplier_label }}</td>
        <td class="lg:pl-3 pl-1 py-2 w-2/12">{{ order.total_price }}</td>
        <td v-if="! isFinished" class="lg:pl-3 pl-1 py-2 w-1/12">
            <div class="w-full flex justify-start lg:gap-6 gap-1">
                <router-link :to="'/orders/edit/' + order.id" class="hover:underline">Edit</router-link>
                <button class="hover:underline" @click="remove()">Delete</button>
            </div>
        </td>
    </tr>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        order: {
            type: Object,
            required: true,
            default: () => {}
        },
        isFinished: {
            type: Boolean,
            required: true,
            default: false
        }
    },
    methods: {
        async remove() {
            await axios.delete(`/api/orders/${this.order.id}`, { headers: this.headers})
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
