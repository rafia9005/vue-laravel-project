<template>
    <div>
      <div v-if="user">
        <h1 class="text-2xl font-bold">{{ user.username }}</h1>
        <h1 class="text-lg">{{ user.email }}</h1>
        <h2 class="text-lg">{{ user.role }}</h2>
        <h2 class="text-lg">{{ user.created_at }}</h2>
      </div>
      <div>
        <table v-if="role === 'admin' && userTotal" class="bg-white border border-gray-300">
          <thead>
            <tr>
              <th class="py-2 px-4 border-b">ID</th>
              <th class="py-2 px-4 border-b">Username</th>
              <th class="py-2 px-4 border-b">Email</th>
              <th class="py-2 px-4 border-b">Role</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in userTotal" :key="user.id">
              <td class="py-2 px-4 border-b">{{ user.id }}</td>
              <td class="py-2 px-4 border-b">{{ user.username }}</td>
              <td class="py-2 px-4 border-b">{{ user.email }}</td>
              <td class="py-2 px-4 border-b">{{ user.role }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        user: null,
        validation: null,
        role: localStorage.getItem("role"),
        userTotal: null,
      };
    },
    async created() {
      const token = localStorage.getItem("token");
      if (!token) {
        this.$router.push("/login");
        return;
      }
  
      try {
        const response = await axios.get("http://localhost:8000/api/profile", {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        });
  
        this.user = response.data;
  
        if (this.role === "admin") {
          const userTotal = await axios.get("http://localhost:8000/api/user", {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          });
          this.userTotal = userTotal.data;
        }
      } catch (error) {
        console.error(error);
        this.validation = error.response.data;
      }
    },
  };
  </script>
  