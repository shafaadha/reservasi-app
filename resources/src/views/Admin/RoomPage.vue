<script setup>
import { ref, onMounted } from "vue";
import { useAuthStore } from "../../stores/auth";
import api from "../../services/api";
import { useFormatter } from "../../composables/useFormatter";

const auth = useAuthStore();
const { formatDate } = useFormatter;

const reservations = ref([]);
const hotelId = ref(null);

const getReservation = async () => {
    try {
        const { data } = await api.get(`/hotel/reservations`);
        console.log(data);
        reservations.value = data.data;
    } catch (error) {
        console.error(error);
    }
};

onMounted(async () => {
    await auth.fetchUser();

    hotelId.value = auth.user.hotel_id;

    await getReservation();
});
</script>

<template></template>
