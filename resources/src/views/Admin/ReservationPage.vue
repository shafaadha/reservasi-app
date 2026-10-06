<script setup>
import { ref, onMounted, computed } from "vue";
import { useAuthStore } from "../../stores/auth";
import api from "../../services/api";
import { useFormatter } from "../../composables/useFormatter";
import StatusBadge from "../../component/common/StatusBadge.vue";
import BaseButton from "../../component/button/BaseButton.vue";
import { VueDatePicker } from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faEllipsis } from "@fortawesome/free-solid-svg-icons";
import BaseInput from "../../component/common/BaseInput.vue";
import BaseInput from "../../component/common/BaseInput.vue";

const auth = useAuthStore();
const { formatDate, formatCurrency } = useFormatter();

const reservations = ref([]);
const loading = ref(true);
const hotelId = ref(null);
const searchName = ref("");
const searchId = ref("");
const searchDate = ref(null);

const selectedStatus = ref("");

const openMenu = ref(null);
const menuPosition = ref({
    top: 0,
    left: 0,
});

const toggleMenu = (id, event) => {
    if (openMenu.value === id) {
        openMenu.value = null;
        return;
    }

    const rect = event.currentTarget.getBoundingClientRect();

    menuPosition.value = {
        top: rect.bottom + 4,
        left: rect.right - 144,
    };

    openMenu.value = id;
};

const statusOptions = [
    { value: "", label: "All Status" },
    { value: "pending", label: "Pending" },
    { value: "confirmed", label: "Confirmed" },
    { value: "checked_in", label: "Checked In" },
    { value: "checked_out", label: "Checked Out" },
    { value: "cancelled", label: "Cancelled" },
];

const viewReservation = (reservation) => {
    console.log("View:", reservation);
    openMenu.value = null;
};

const editReservation = (reservation) => {
    console.log("Edit:", reservation);
    openMenu.value = null;
};

const deleteReservation = (reservation) => {
    console.log("Delete:", reservation);
    openMenu.value = null;
};

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

        const matchStatus =
            !selectedStatus.value ||
            reservation.status === selectedStatus.value;

        const matchDate =
            !searchDate.value ||
            reservation.check_in?.substring(0, 10) === searchDate.value;

        return matchName && matchId && matchDate && matchStatus;
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
        class="col-span-1 md:col-span-4 xl:col-span-4 bg-white rounded-xl shadow-md p-6 text-gray-800"
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

        <div class="grid grid-cols-5 gap-4">
            <!-- Search -->
            <div class="col-span-1">
                <BaseInput v-model="searchName" placeholder="Search" />
            </div>

            <!-- Date Picker -->
            <div class="col-span-1">
                <VueDatePicker
                    v-model="searchDate"
                    range
                    :enable-time-picker="false"
                    placeholder="Check in - Check out"
                    class="w-full"
                />
            </div>

            <!-- Status -->
            <div class="col-span-1">
                <BaseSelect v-model="selectedStatus" :options="statusOptions" />
            </div>
        </div>

        <div class="overflow-x-auto overflow-y-visible">
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

                        <th
                            class="px-4 py-3 text-center font-semibold text-gray-600"
                        >
                            Action
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

                            <td class="px-4 py-3 text-center">
                                <button
                                    type="button"
                                    @click="toggleMenu(reservation.id, $event)"
                                    class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700"
                                >
                                    <FontAwesomeIcon :icon="faEllipsis" />
                                </button>
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
            <ActionMenu
                :items="[
                    {
                        label: 'View',
                        action: () => viewReservation(reservation),
                    },
                    {
                        label: 'Edit',
                        action: () => editReservation(reservation),
                    },
                    {
                        label: 'Delete',
                        action: () => deleteReservation(reservation),
                        danger: true,
                    },
                ]"
            />
        </div>
    </div>
</template>
