<script setup>
import Navbar from "../components/NavbarLayout.vue";
import Hero from "../components/HeroLayout.vue";
</script>

<template>
    <Navbar />
    <Hero />
    <div v-if="post && post.length > 0">
        <h1 v-for="item in post" :key="item.id">
            {{ item.id }}
            {{ item.title }}
            {{ item.news_content }}
            {{ item.author }}
            <button @click="deletePost(item.id)">Delete</button>
        </h1>
    </div>
    <div v-else>
        <h1>oke</h1>
    </div>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            post: null,
            error: null,
        };
    },
    async created() {
        try {
            const response = await axios.get("http://localhost:8000/api/post", {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("token")}`,
                },
            });
            this.post = response.data.data;
            console.log(response.data.data);
        } catch (error) {
            this.error = error.response.data;
        }
    },
    methods: {
        async deletePost(postId) {
            try {
                await axios.delete(`http://localhost:8000/api/post/${postId}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "token"
                        )}`,
                    },
                });
                // refresh website
                window.location.reload();
            } catch (error) {
                console.error(error);
            }
        },
    },
};
</script>
