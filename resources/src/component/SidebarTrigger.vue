<script setup>
import { useSidebar } from '../composables/useSidebar';

const { toggleSidebar } = useSidebar();
</script>

<template>
    <button
        class="h-8 w-8 flex items-center justify-center rounded-md hover:bg-gray-200 transition"
        @click="toggleSidebar"
    >
        ☰
    </button>
</template>
