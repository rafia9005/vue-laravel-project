<template>
    <h1>Login Test</h1>
    <form @submit.prevent="loginHandler">
        <h1 class="text-3xl" v-if="validation">{{ validation.message }}</h1>
        <input
            v-model="email"
            type="email"
            name="email"
            class="border border-black p-2"
            required
            autofocus
        />
        <input
            v-model="password"
            type="password"
            name="password"
            class="border border-black p-2"
            required
        />
        <button type="submit">Login</button>
    </form>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            email: "",
            password: "",
            validation: {},
        };
    },
    methods: {
        async loginHandler() {
            const formData = new FormData();
            formData.append("email", this.email);
            formData.append("password", this.password);

            try {
                const response = await axios.post(
                    "http://localhost:8000/api/login",
                    formData
                );
                const token = response.data.access_token;
                localStorage.setItem("token", token);
                const roleCheck = await axios.get(
                    "http://localhost:8000/api/profile",
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "token"
                            )}`,
                        },
                    }
                );
                const role = roleCheck.data.role;
                localStorage.setItem("role", role);
                this.$router.push("/dashboard");
            } catch (error) {
                this.validation = error.response.data;
            }
        },
    },
    created() {
        if (localStorage.getItem("token")) {
            this.$router.push("/dashboard");
        }
    },
};
</script>
