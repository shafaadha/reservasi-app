<script setup>
import { RouterLink, useRouter } from "vue-router";
import { ref, onMounted } from "vue";
import api, { setAuthToken } from "./services/api"; // axios instance

const router = useRouter();
const isLoggedIn = ref(false);

onMounted(() => {
  if (localStorage.getItem("token")) {
    isLoggedIn.value = true;
  }

  window.addEventListener("login-success", () => {
    isLoggedIn.value = true;
  });
});

// fungsi logout
async function logout() {
  try {
    await api.post("/logout");
  } catch (e) {
    console.warn("Logout API gagal");
  } finally {
    localStorage.removeItem("token");
    setAuthToken(null);
    isLoggedIn.value = false;
    router.push({ name: "hotels" });
  }
}
</script>

<template>
  <div class="navigator mb-10 bg-blue-500 text-white p-4 rounded-b-lg shadow flex items-center justify-between">
    <div>
      <RouterLink to="/home" class="text-2xl font-bold">Reservasi Hotel</RouterLink>
    </div>
    <ul class="flex items-center space-x-6">
      <li>
        <RouterLink to="/rooms">Room</RouterLink>
      </li>
      <li>
        <RouterLink to="/about">About us</RouterLink>
      </li>
      <li v-if="!isLoggedIn">
        <RouterLink to="/login">Login</RouterLink>
      </li>
      <li v-else>
        <button v-on:click="logout">Logout</button>
      </li>
    </ul>
  </div>



  <div id="app">
    <router-view />
  </div>
</template>

<style></style>
