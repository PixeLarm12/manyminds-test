import {createApp} from 'vue'
import {createRouter, createWebHistory} from 'vue-router'

import App from './App.vue'

import Auth from './Pages/Auth.vue'

import Products from './Pages/Products/Products.vue'
import ProductCreate from './Pages/Products/ProductCreate.vue'

import Orders from './Pages/Orders/Orders.vue'
import OrderCreate from './Pages/Orders/OrderCreate.vue'

const routes = [
    {path: '/', component: Products, meta: { title: 'Products'}},
    {path: '/login', component: Auth, meta: {"title": "Login"}},
    
    // products routes
    {path: '/products/create', component: ProductCreate, meta: { title: 'Create Product'}},
    {path: '/products/edit/:id', component: ProductCreate, meta: { title: 'Edit Product'}},
    
    // orders routes
    {path: '/orders', component: Orders, meta: { title: 'Orders'}},
    {path: '/orders/create', component: OrderCreate, meta: { title: 'Create Order'}},
    {path: '/orders/edit/:id', component: OrderCreate, meta: { title: 'Edit Order'}},
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