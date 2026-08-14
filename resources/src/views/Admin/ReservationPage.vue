<script setup>
import { ref, onMounted } from "vue";
import { useAuthStore } from "../../stores/auth";
import api from "../../services/api";
import { useFormatter } from "../../composables/useFormatter";
import StatusBadge from "../../component/StatusBadge.vue";
import BaseButton from "../../component/button/BaseButton.vue";

const auth = useAuthStore();
const { formatDate, formatCurrency } = useFormatter();

const reservations = ref([]);
const loading = ref([true]);
const hotelId = ref(null);

const getReservation = async () => {
    try {
        const { data } = await api.get(`/hotel/reservations`);
        console.log(data);
        reservations.value = data.data;
        loading.value = false;
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

<template>
    <div
        class="col-span-1 md:col-span-4 xl:col-span-4 bg-white rounded-xl shadow-md p-6"
    >
        <div class="flex flex-row justify-between">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">
                        Latest Reservations
                    </h2>
                    <p class="text-sm text-gray-500">
                        Daftar reservasi terbaru
                    </p>
                </div>
            </div>

            <div><BaseButton text="Reservation"></BaseButton></div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-500">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-4 py-3 text-left font-semibold text-gray-600"
                        >
                            ID
                        </th>

                        <th
                            class="px-4 py-3 text-left font-semibold text-gray-600"
                        >
                            Guest
                        </th>

                        <th
                            class="px-4 py-3 text-left font-semibold text-gray-600"
                        >
                            Room
                        </th>

                        <th
                            class="px-4 py-3 text-left font-semibold text-gray-600"
                        >
                            Check In
                        </th>

                        <th
                            class="px-4 py-3 text-left font-semibold text-gray-600"
                        >
                            Check Out
                        </th>

                        <th
                            class="px-4 py-3 text-center font-semibold text-gray-600"
                        >
                            Status
                        </th>

                        <th
                            class="px-4 py-3 text-center font-semibold text-gray-600"
                        >
                            Payment
                        </th>

                        <th
                            class="px-4 py-3 text-right font-semibold text-gray-600"
                        >
                            Total
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="loading">
                        <td colspan="7" class="text-center py-8 text-gray-400">
                            Loading
                        </td>
                    </tr>

                    <tr
                        v-else-if="reservations.length"
                        v-for="reservation in reservations"
                        :key="reservation.id"
                    >
                        <td class="text-left px-4 py-3">
                            {{ reservation.id }}
                        </td>
                        <td>{{ reservation.user.name }}</td>
                        <td class="px-4 py-4">
                            <span
                                v-for="room in reservation.room_units"
                                :key="room.id"
                                class="mr-2"
                            >
                                {{ room.room_number }}
                            </span>
                        </td>
                        <td>{{ formatDate(reservation.check_in) }}</td>
                        <td>{{ formatDate(reservation.check_out) }}</td>
                        <td class="text-center">
                            <StatusBadge
                                :status="reservation.status"
                            ></StatusBadge>
                        </td>
                        <td class="text-center">
                            <StatusBadge
                                :status="reservation.payment.status"
                            ></StatusBadge>
                        </td>
                        <td class="text-right">
                            {{ formatCurrency(reservation.total_price) }}
                        </td>
                    </tr>

                    <tr v-else>
                        <td colspan="7" class="text-center py-8 text-gray-400">
                            Belum ada reservasi.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
