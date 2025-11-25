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
  <div class="navigator bg-cyan-400 text-white p-4 rounded-b-lg shadow flex items-center justify-between">
    <div>
      <RouterLink to="/" class="text-2xl font-bold">Reservasi Hotel</RouterLink>
    </div>
    <ul class="flex items-center space-x-2">
      <li class="hover:bg-cyan-600 rounded-md">
        <RouterLink to="/rooms" class="block px-4 py-2" active-class="bg-cyan-700 rounded-md">Room</RouterLink>
      </li>
      <li class="hover:bg-cyan-700 hover:rounded-md">
        <RouterLink to="/about" class="block px-4 py-2" active-class="bg-cyan-700 rounded-md">About us</RouterLink>
      </li>
      <li v-if="!isLoggedIn" class="hover:bg-cyan-600 hover:rounded-md">
        <RouterLink to="/login" class="block px-4 py-2" active-class="bg-cyan-600 rounded-md">Login</RouterLink>
      </li>
      <li v-else class="hover:bg-cyan-600 hover:rounded-md">
        <button v-on:click="logout">Logout</button>
      </li>
    </ul>
  </div>



  <div id="app">
    <router-view />
  </div>
</template>

<style></style>
