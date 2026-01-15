<script setup>
import { useRoute } from "vue-router";

const route = useRoute();
const bookingId = route.query.id;
</script>

<template>
    <div class="max-h-screen mx-auto mt-10 bg-white shadow-lg rounded-lg p-6 center">
        <h1>Booking Berhasil</h1>
        <p>ID Booking: {{ bookingId }}</p>
    </div>
</template>
