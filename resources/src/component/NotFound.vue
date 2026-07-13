<template>
    <div
        class="min-h-screen flex flex-col items-center justify-center bg-gray-50 text-black"
    >
        <h1 class="text-5xl font-bold mb-4">404</h1>
        <p class="text-xl mb-4">Page is Not Found</p>
        <button @click="goBack" class="text-blue-600 hover:underline">
            Go Back
        </button>
    </div>
</template>

<script setup>
import { useRouter } from "vue-router";

const router = useRouter();

function goBack() {
    if (window.history.length > 1) {
        router.back();
    } else {
        router.push("/");
    }
}
</script>
