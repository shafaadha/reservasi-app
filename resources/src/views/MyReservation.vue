<script setup>
import { ref, onMounted } from "vue";
import api from "../services/api";
import router from "../router";
import ReservationList from "../component/reservation/ReservationList.vue";
import ReservationCardSkeleton from "../component/reservation/ReservationCardSkeleton.vue";

const hotels = ref([]);
const loading = ref(true);

onMounted(async () => {
    try {
        const { data } = await api.get("/my-reservations");
        hotels.value = Array.isArray(data) ? data : [];
    } finally {
        loading.value = false;
    }
});

const paymentDetail = (reservation) => {
    router.push({
        name: "detailPayment",
        query: {
            reservationId: reservation.id,
        },
    });
};
</script>

<template>
    <section class="max-w-3xl mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-4 text-gray-700">
            My Reservations
        </h1>

        <ReservationCardSkeleton v-if="loading" :count="5" />

        <div v-else-if="hotels.length === 0">Tidak ada reservasi</div>

        <ReservationList
            v-else
            :reservations="hotels"
            @payment="paymentDetail"
        />
    </section>
</template>
