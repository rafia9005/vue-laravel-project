<template>
  <h1>Halaman Register</h1>
  <form @submit.prevent="registerHandler">
    <input
      v-model="username"
      type="text"
      name="username"
      placeholder="Masukan Username mu"
      required
      autofocus
    />
    <input
      v-model="email"
      type="email"
      name="email"
      placeholder="Masukan email mu"
      required
    />
    <input
      v-model="password"
      type="password"
      name="password"
      placeholder="Masukan password mu"
      required
    />
    <button type="submit">Register</button>
  </form>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      username: "",
      email: "",
      password: "",
    };
  },
  methods: {
    async registerHandler() {
      const formData = new FormData();
      formData.append("username", this.username);
      formData.append("email", this.email);
      formData.append("password", this.password);

      try {
        const response = await axios.post(
          "http://localhost:8000/api/register",
          formData,
          {
            headers: { "Content-Type": "multipart/form-data" },
          }
        );
        const token = response.data.access_token;
        localStorage.setItem("token", token);
        const roleCheck = await axios.get("http://localhost:8000/api/profile", {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        });
        const role = roleCheck.data.role;
        localStorage.setItem("role", role);
        this.$router.push("/dashboard");
      } catch (error) {
        console.log(error);
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
