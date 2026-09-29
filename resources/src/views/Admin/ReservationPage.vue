<script setup>
import { ref, onMounted, computed } from "vue";
import { useAuthStore } from "../../stores/auth";
import api from "../../services/api";
import { useFormatter } from "../../composables/useFormatter";
import StatusBadge from "../../component/common/StatusBadge.vue";
import BaseButton from "../../component/button/BaseButton.vue";

const auth = useAuthStore();
const { formatDate, formatCurrency } = useFormatter();

const reservations = ref([]);
const loading = ref(true);
const hotelId = ref(null);
const searchName = ref("");
const searchId = ref("");

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

const filteredReservation = computed(() => {
    return reservations.value.filter((reservation) => {
        const matchName = reservation.user?.name
            ?.toLowerCase()
            .includes(searchName.value.toLowerCase());

        const matchId = reservation.id?.toString().includes(searchId.value);

        return matchName && matchId;
    });
});

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
                    <input
                        v-model="searchName"
                        type="text"
                        placeholder="Search guest name..."
                    />
                </div>
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
                    <!-- Loading Skeleton -->
                    <template v-if="loading">
                        <tr v-for="n in 5" :key="n" class="animate-pulse">
                            <!-- ID -->
                            <td class="px-4 py-4">
                                <div class="h-4 w-10 rounded bg-gray-200"></div>
                            </td>

                            <!-- Guest -->
                            <td class="px-4 py-4">
                                <div class="h-4 w-28 rounded bg-gray-200"></div>
                            </td>

                            <!-- Room -->
                            <td class="px-4 py-4">
                                <div class="flex gap-2">
                                    <div
                                        class="h-5 w-10 rounded bg-gray-200"
                                    ></div>
                                    <div
                                        class="h-5 w-10 rounded bg-gray-200"
                                    ></div>
                                </div>
                            </td>

                            <!-- Check In -->
                            <td class="px-4 py-4">
                                <div class="h-4 w-24 rounded bg-gray-200"></div>
                            </td>

                            <!-- Check Out -->
                            <td class="px-4 py-4">
                                <div class="h-4 w-24 rounded bg-gray-200"></div>
                            </td>

                            <!-- Status -->
                            <td class="px-4 py-4">
                                <div class="flex justify-center">
                                    <div
                                        class="h-6 w-20 rounded-full bg-gray-200"
                                    ></div>
                                </div>
                            </td>

                            <!-- Payment -->
                            <td class="px-4 py-4">
                                <div class="flex justify-center">
                                    <div
                                        class="h-6 w-20 rounded-full bg-gray-200"
                                    ></div>
                                </div>
                            </td>

                            <!-- Total -->
                            <td class="px-4 py-4">
                                <div
                                    class="ml-auto h-4 w-28 rounded bg-gray-200"
                                ></div>
                            </td>
                        </tr>
                    </template>

                    <!-- Data -->
                    <template v-else-if="reservations.length">
                        <tr
                            v-for="reservation in filteredReservation"
                            :key="reservation.id"
                            class="border-b border-gray-100"
                        >
                            <td class="px-4 py-3">
                                {{ reservation.id }}
                            </td>

                            <td class="px-4 py-3">
                                {{ reservation.user.name }}
                            </td>

                            <td class="px-4 py-4">
                                <span
                                    v-for="room in reservation.room_units"
                                    :key="room.id"
                                    class="mr-2"
                                >
                                    {{ room.room_number }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                {{ formatDate(reservation.check_in) }}
                            </td>

                            <td class="px-4 py-3">
                                {{ formatDate(reservation.check_out) }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                <StatusBadge :status="reservation.status" />
                            </td>

                            <td class="px-4 py-3 text-center">
                                <StatusBadge
                                    :status="reservation.payment.status"
                                />
                            </td>

                            <td class="px-4 py-3 text-right">
                                {{ formatCurrency(reservation.total_price) }}
                            </td>
                        </tr>
                    </template>

                    <!-- Empty -->
                    <tr v-else>
                        <td colspan="8" class="py-8 text-center text-gray-400">
                            Belum ada reservasi.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
