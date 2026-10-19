<script setup>
import { provide, ref } from "vue";
import { useIsMobile } from "../../../composables/useIsMobile";

const openMobile = ref(false);
const isMobile = useIsMobile();

function setOpenMobile(value) {
    openMobile.value = value;
}

provide("sidebar", {
    openMobile,
    isMobile,
    setOpenMobile,
});
</script>

<template>
    <slot />
</template>
