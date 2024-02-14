<template>
    <div class="min-h-screen w-screen">
        <div id="nav-bar">
            <ul>
                <li class="text-3xl text-orange-400"> <router-link to="/">Home</router-link> </li>
                <li class="text-3xl text-orange-400"> <router-link to="/about">About</router-link> </li>
            </ul>
        </div>

        <main>
            <router-view></router-view>
        </main>
    </div>
</template>