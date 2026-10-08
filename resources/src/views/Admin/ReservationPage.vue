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
import BaseSelect from "../../component/common/BaseSelect.vue";
import ActionMenu from "../../component/common/ActionMenu.vue";
import TableSkeleton from "../../component/common/TableSkeleton.vue";

const auth = useAuthStore();
const { formatDate, formatCurrency } = useFormatter();

const reservations = ref([]);
const loading = ref(true);
const hotelId = ref(null);
const search = ref("");
const searchDate = ref([]);

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

const reservationSkeletonColumns = [
    {
        width: "w-10",
    },
    {
        width: "w-28",
    },
    {
        width: "w-16",
    },
    {
        width: "w-24",
    },
    {
        width: "w-24",
    },
    {
        width: "w-20",
        align: "center",
    },
    {
        width: "w-20",
        align: "center",
    },
    {
        width: "w-28",
        align: "right",
    },
    {
        width: "w-10",
        align: "center",
    },
];

const getActionItems = (reservation) => {
    const items = [
        {
            label: "View",
            action: () => viewReservation(reservation),
        },
    ];

    if (
        reservation.status === "pending" ||
        reservation.status === "confirmed"
    ) {
        items.push({
            label: "Edit",
            action: () => editReservation(reservation),
        });

        items.push({
            label: "Cancel",
            action: () => deleteReservation(reservation),
            danger: true,
        });
    }

    if (
        reservation.status === "pending"
    ) {
        items.push({
            label: "Confirm",
            action: () => editReservation(reservation),
        });
    }

    return items;
};

const selectedReservation = computed(() =>
    reservations.value.find((reservation) => reservation.id === openMenu.value),
);

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
    } finally {
        loading.value = false;
    }
};

const filteredReservation = computed(() => {
    const keyword = search.value.toLowerCase().trim();

    const startDate = searchDate.value[0]
        ? formatDate(searchDate.value[0])
        : null;

    const endDate = searchDate.value[1]
        ? formatDate(searchDate.value[1])
        : null;

    return reservations.value.filter((reservation) => {
        const matchSearch =
            reservation.user?.name?.toLowerCase().includes(keyword) ||
            reservation.id?.toString().includes(keyword);

        const matchStatus =
            !selectedStatus.value ||
            reservation.status === selectedStatus.value;

        const matchDate =
            (!startDate || checkIn >= startDate) &&
            (!endDate || checkIn <= endDate);

        return matchSearch && matchDate && matchStatus;
    });
});

onMounted(async () => {
    await auth.fetchUser();

    hotelId.value = auth.user.hotel_id;

    await getReservation();
});
</script>

<template>
    <div class="col-span-1 md:col-span-4 xl:col-span-4 bg-white rounded-xl shadow-md p-6 text-gray-800">
        <div class="flex flex-row justify-between">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">
                        Reservations List
                    </h2>
                    <p class="text-sm text-gray-500">
                        Daftar reservasi terbaru
                    </p>
                </div>
            </div>
            <div>
                <BaseButton text="Reservation"></BaseButton>
            </div>
        </div>

        <div class="grid grid-cols-5 gap-4">
            <!-- Search -->
            <div class="col-span-1">
                <BaseInput v-model="search" placeholder="Search ID or Name" />
            </div>

            <!-- Date Picker -->
            <div class="col-span-1">
                <VueDatePicker v-model="searchDate" range :enable-time-picker="false" placeholder="Check in - Check out"
                    class="w-full" />
            </div>

            <!-- Status -->
            <div class="col-span-1">
                <BaseSelect v-model="selectedStatus" :options="statusOptions" />
            </div>

            <div>
                <BaseButton></BaseButton>
            </div>
        </div>

        <div class="overflow-x-auto overflow-y-visible">
            <table class="min-w-full text-sm text-gray-500">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">
                            ID
                        </th>

                        <th class="px-4 py-3 text-left font-semibold text-gray-600">
                            Guest
                        </th>

                        <th class="px-4 py-3 text-left font-semibold text-gray-600">
                            Room
                        </th>

                        <th class="px-4 py-3 text-left font-semibold text-gray-600">
                            Check In
                        </th>

                        <th class="px-4 py-3 text-left font-semibold text-gray-600">
                            Check Out
                        </th>

                        <th class="px-4 py-3 text-center font-semibold text-gray-600">
                            Status
                        </th>

                        <th class="px-4 py-3 text-center font-semibold text-gray-600">
                            Payment
                        </th>

                        <th class="px-4 py-3 text-right font-semibold text-gray-600">
                            Total
                        </th>

                        <th class="px-4 py-3 text-center font-semibold text-gray-600">
                            Action
                        </th>
                    </tr>
                </thead>

                <!--loading-->
                <tbody v-if="loading">
                    <TableSkeleton :columns="reservationSkeletonColumns" :rows="1" />
                </tbody>

                <!--not found-->
                <tbody v-if="filteredReservation.length === 0">
                    <tr>
                        <td colspan="9" class="py-8 text-center text-gray-400">
                            No reservations match your current filters.
                        </td>
                    </tr>
                </tbody>

                <!-- Data -->
                <tbody v-else-if="reservations.length">
                    <tr v-for="reservation in filteredReservation" :key="reservation.id"
                        class="border-b border-gray-100">
                        <td class="px-4 py-3">
                            {{ reservation.id }}
                        </td>

                        <td class="px-4 py-3">
                            {{ reservation.user.name }}
                        </td>

                        <td class="px-4 py-4">
                            <span v-for="room in reservation.room_units" :key="room.id" class="mr-2">
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
                            <StatusBadge :status="reservation.payment.status" />
                        </td>

                        <td class="px-4 py-3 text-right">
                            {{ formatCurrency(reservation.total_price) }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            <button type="button" @click="toggleMenu(reservation.id, $event)"
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                <FontAwesomeIcon :icon="faEllipsis" />
                            </button>
                        </td>
                    </tr>
                </tbody>

                <tbody v-else>
                    <tr>
                        <td colspan="9" class="py-8 text-center text-gray-400">
                            Belum ada reservasi.
                        </td>
                    </tr>
                </tbody>
            </table>

            <ActionMenu v-if="selectedReservation" :items="getActionItems(selectedReservation)"
                :position="menuPosition" />
        </div>
    </div>
</template>
