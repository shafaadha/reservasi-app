<script setup>
import { provide, ref } from "vue";

const openMobile = ref(false);

function setOpenMobile(val) {
    openMobile.value = val;
}

provide("sidebar", {
    openMobile,
    setOpenMobile,
});
</script>

<template>
    <slot />
</template>
