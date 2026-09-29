<script setup>
import AppFooter from "../component/layout/AppFooter.vue";
import Navigator from "../component/layout/Navigator.vue";
import { useRoute } from "vue-router";

const route = useRoute();
</script>

<!-- <template>
    <div class="min-h-screen bg-gray-100">
        <Navigator />

        <main class="bg-gray-100 p-6">
            <router-view />
        </main>

        <AppFooter v-if="!route.meta.hideFooter" />
    </div>
</template> -->
<template>
    <div class="flex min-h-screen flex-col bg-gray-100">
        <Navigator />

        <main class="flex-1 bg-gray-100">
            <router-view />
        </main>

        <AppFooter v-if="!route.meta.hideFooter" />
    </div>
</template>
