<script setup>
import BaseButton from "../button/BaseButton.vue";

const props = defineProps({
    reservation: Object,
});

const emit = defineEmits(["payment"]);

const formatPrice = (price) => new Intl.NumberFormat("id-ID").format(price);

const formatDate = (date) => new Date(date).toLocaleDateString("id-ID");

const statusClass = (status) => {
    return (
        {
            pending: "bg-yellow-100 text-yellow-700",
            settlement: "bg-green-100 text-green-700",
            confirmed: "bg-green-100 text-green-700",
            cancelled: "bg-red-100 text-red-700",
        }[status] || "bg-gray-100 text-gray-700"
    );
};
</script>

<template>
    <div class="rounded-2xl shadow p-5 border border-gray-200">
        <div class="flex justify-between items-center mb-2">
            <p class="font-medium">
                {{ formatDate(reservation.check_in) }}
                →
                {{ formatDate(reservation.check_out) }}
            </p>

            <span
                class="px-3 py-1 rounded-full text-sm"
                :class="statusClass(reservation.status)"
            >
                {{ reservation.status }}
            </span>
        </div>

        <p class="text-sm text-gray-600">
            Guests: {{ reservation.guests }} · Room:
            {{ reservation.room_booked }}
        </p>

        <div class="flex justify-between items-center mt-3">
            <p class="font-semibold">
                Total Price:
                <span class="text-green-600">
                    Rp {{ formatPrice(reservation.total_price) }}
                </span>
            </p>

            <BaseButton
                v-if="reservation.payment?.status === 'pending'"
                text="Payment"
                @click="emit('payment', reservation)"
            />
        </div>
    </div>
</template>
