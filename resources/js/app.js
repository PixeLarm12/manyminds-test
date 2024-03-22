import {createApp} from 'vue'
import {createRouter, createWebHistory} from 'vue-router'

import App from './App.vue'

import Home from './Pages/Home.vue'

const routes = [
    {path: '/', component: Home, meta: {"title": "Home"}},
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    document.title = to.meta.title

    next()
});

createApp(App).use(router).mount("#app")