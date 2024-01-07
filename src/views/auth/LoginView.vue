<template>
  <div>
    <h1>Halaman Login</h1>
    <form @submit.prevent="loginHandler">
      <input
        v-model="email"
        type="email"
        name="email"
        placeholder="Masukan Email"
        required
        autofocus
      />
      <input
        v-model="password"
        type="password"
        name="password"
        placeholder="Masukan Password"
        required
      />
      <button type="submit">Login</button>
      <p v-if="validation.message" class="text-red-500">
        {{ validation.message }}
      </p>
    </form>
  </div>
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
        // save token to localStorage
        const token = response.data.access_token;
        localStorage.setItem("token", token);
        const roleCheck = await axios.get("http://localhost:8000/api/profile", {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        });
        // save role to localStorage
        const role = roleCheck.data.role;
        localStorage.setItem('role', role)
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
