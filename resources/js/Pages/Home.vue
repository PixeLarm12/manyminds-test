<template>
    <default-header></default-header>
    
    <div class="flex flex-col justify-center items-center">
        <h1>Home Page - Project Example</h1>
    </div>
</template>

<script>
import DefaultHeader from '../Components/DefaultHeader.vue';

export default {
    beforeMount() {
        if(! localStorage.getItem('jwt_token')) {
            this.$router.push("/login");
        }
    },
    components: {
        DefaultHeader,
    }
}
</script>
