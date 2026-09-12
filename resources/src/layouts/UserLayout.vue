<script setup>
import AppFooter from "../component/AppFooter.vue";
import Navigator from "../component/Navigator.vue";
</script>

<template>
    <Navigator />

    <div class="min-h-screen bg-gray-100">
        <router-view />
    </div>

    <AppFooter />
</template>
