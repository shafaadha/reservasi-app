<script setup>
import ReservationCard from "./ReservationCard.vue";

defineProps({
    reservations: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(["payment"]);
</script>

<template>
    <div class="min-h-full">
        <ReservationCard
            v-for="reservation in reservations"
            :key="reservation.id"
            :reservation="reservation"
            @payment="emit('payment', $event)"
        />
    </div>
</template>
