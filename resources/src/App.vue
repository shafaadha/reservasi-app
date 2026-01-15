<script setup>
import AppFooter from "./component/AppFooter.vue";
import Navigator from "./component/Navigator.vue";
import { setAuthToken } from "./services/api";

const token = localStorage.getItem("token");
if (token) {
    setAuthToken(token);
}
</script>

<template>
    <Navigator></Navigator>
    <div id="app">
        <router-view />
    </div>
    <AppFooter></AppFooter>
</template>

<style></style>
