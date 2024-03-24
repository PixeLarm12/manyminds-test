import {createApp} from 'vue'
import {createRouter, createWebHistory} from 'vue-router'

import App from './App.vue'

import Home from './Pages/Home.vue'
import Auth from './Pages/Auth.vue'

import products from './Pages/Products/Products.vue'
import ProductCreate from './Pages/Products/ProductCreate.vue'

const routes = [
    {path: '/', component: Home, meta: {"title": "Home"}},
    {path: '/login', component: Auth, meta: {"title": "Login"}},
    {path: '/products', component: products, meta: { title: 'Products'}},
    {path: '/products/create', component: ProductCreate, meta: { title: 'Create Product'}},
    {path: '/products/edit/:id', component: ProductCreate, meta: { title: 'Edit Product'}},
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