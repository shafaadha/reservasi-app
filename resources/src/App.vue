<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";

import AdminLayout from "./layouts/AdminLayout.vue";
import UserLayout from "./layouts/UserLayout.vue";
import { setAuthToken } from "./services/api";

const route = useRoute();

const token = localStorage.getItem("token");
if (token) {
  setAuthToken(token);
}

const layout = computed(() => route.meta.layout || "user");
</script>

<template>
  <AdminLayout v-if="layout === 'admin'" />
  <UserLayout v-else />
</template>
