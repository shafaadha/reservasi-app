<script setup>
import { useSidebar } from "../../composables/useSidebar";

const { openMobile, setOpenMobile } = useSidebar();

function toggleSidebar() {
    setOpenMobile(!openMobile);
}
</script>

<template>
    <button @click="toggleSidebar" class="p-2 rounded-md hover:bg-gray-200">
        ☰
    </button>
</template>
