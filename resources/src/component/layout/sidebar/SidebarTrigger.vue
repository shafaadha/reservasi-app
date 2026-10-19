<script setup>
import { useSidebar } from "../../../composables/useSidebar";

const { openMobile, setOpenMobile } = useSidebar();

function toggleSidebar() {
    setOpenMobile(!openMobile.value);
}
</script>

<template>
    <button type="button" @click="toggleSidebar" class="rounded-md p-2 hover:bg-gray-200 md:hidden">
        ☰
    </button>
</template>
