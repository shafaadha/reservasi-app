<script setup>
import AppFooter from "../component/layout/AppFooter.vue";
import Navigator from "../component/layout/Navigator.vue";
import { useRoute } from "vue-router";

const route = useRoute();
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <Navigator />

        <main class="bg-gray-100">
            <router-view />
        </main>

        <AppFooter v-if="!route.meta.hideFooter" />
    </div>
</template>
