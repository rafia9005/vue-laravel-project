<template>
    <nav class="flex justify-evenly items-center py-3 bg-black text-white fixed w-full">
        <h1 class="text-2xl">Lomba LKS</h1>
        <ul class="flex gap-[10px]">
            <li><router-link v-if="!token" to="/login">Login</router-link></li>
            <li><router-link v-if="!token" to="/register">Register</router-link></li>
            <li><router-link v-if="token" to="/dashboard">Dashboard</router-link></li>
            <li><router-link v-if="token" to="/logout">Logout</router-link></li>
        </ul>
    </nav>
</template>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            token: localStorage.getItem('token'),
        };
    },
};
</script>
