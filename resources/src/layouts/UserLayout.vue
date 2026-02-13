<script setup>
import AppFooter from "../component/AppFooter.vue";
import Navigator from "../component/Navigator.vue";
</script>

<template>
    <Navigator />

    <div class="min-h-screen">
        <router-view />
    </div>

    <AppFooter />
</template>
