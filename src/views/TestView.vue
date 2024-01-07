<template>
    <h1>Login Test</h1>
    <form @submit.prevent="loginHandler">
        <h1 class="text-3xl" v-if="validation">{{ validation.message }}</h1>
        <input
            v-model="title"
            type="text"
            name="title"
            class="border border-black p-2"
            required
            autofocus
        />
        <input
            v-model="news_content"
            type="text"
            name="news_content"
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
            title: "",
            news_content: "",
            validation: {},
        };
    },
    methods: {
        async loginHandler() {
            const formData = new FormData();
            formData.append("title", this.title);
            formData.append("news_content", this.news_content);

            try {
                const response = await axios.put(
                    "http://localhost:8000/api/post/4",
                    formData, {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem('token')}`,
                            "Content-Type" : "application/json"
                        }
                    }
                );

            } catch (error) {
                this.validation = error.response.data;
            }
        },
    },
    created() {
        // if (localStorage.getItem("token")) {
        //     this.$router.push("/dashboard");
        // }
    },
};
</script>
