<script setup>
import StatCard from "../../component/card/StatCard.vue";
import {
    CalendarDaysIcon,
    CurrencyDollarIcon,
    BuildingOfficeIcon,
    UsersIcon,
} from "@heroicons/vue/16/solid";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faHouse } from "@fortawesome/free-solid-svg-icons";
import api from "../../services/api.js";
import { onMounted, ref } from "vue";

const dashboard = ref({
    summary: {
        totalUnit: 0,
        availableUnit: 0,
        occupiedUnit: 0,
        resToday: 0,
        revToday: 0,
    },
    latestReservations: [],
});

const chartOptions = {
    chart: {
        toolbar: {
            show: false,
        },
    },

    zoom: {
        enabled: true,
    },

    colors: ["#2563EB"],

    stroke: {
        curve: "smooth",
        width: 3,
    },

    fill: {
        type: "gradient",
    },

    dataLabels: {
        enabled: false,
    },

    yaxis: {
        show: false,
    },
    xaxis: {
        categories: ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"],

        axisBorder: {
            show: false,
        },

        axisTicks: {
            show: false,
        },

        labels: {
            style: {
                colors: "#6B7280",
                fontSize: "13px",
            },
        },
    },

    tooltip: {
        enabled: true,
    },

    grid: {
        show: false,
        padding: { top: 20, left: 20, right: 20 },
    },
};

const series = [
    {
        name: "series-1",
        data: [30, 40, 35, 50, 49, 60, 70],
    },
];

const getDashboardData = async () => {
    try {
        const { data } = await api.get("/dashboard");
        dashboard.value = data;

        console.log(dashboard.value.unitRes);
        console.log(data);
    } catch (err) {
        console.log(err);
    }
};

onMounted(() => {
    getDashboardData();
});
</script>

<template>
    <div class="">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
            <!-- Cards -->
            <StatCard
                title="Total Reservasi Hari Ini"
                :icon="CalendarDaysIcon"
                :value="dashboard.summary.totalUnit"
            />
            <StatCard
                title="Kamar Terisi"
                :icon="faHouse"
                iconType="fontawesome"
                :value="dashboard.summary.availableUnit"
            />
            <StatCard
                title="Tamu Check In"
                :icon="UsersIcon"
                :value="dashboard.summary.resToday"
            />
            <StatCard
                title="Pendapatan Hari Ini"
                :icon="CurrencyDollarIcon"
                :value="`Rp ${dashboard.summary.revToday}`"
            />

            <!-- Charts -->
            <div
                class="bg-white col-span-1 md:col-span-2 xl:col-span-2 rounded-2xl shadow-md p-6"
            >
                <div class="text-gray-500 text-xl py-2">
                    <p>Chart Reservation</p>
                </div>
                <apexchart
                    type="area"
                    height="250"
                    width="100%"
                    :options="chartOptions"
                    :series="series"
                />
            </div>
            <div
                class="col-span-1 md:col-span-2 xl:col-span-2 bg-amber-900 h-64 rounded-lg"
            >
                Chart Reservasi
            </div>

            <div
                class="col-span-1 md:col-span-4 xl:col-span-4 bg-white rounded-xl shadow-md p-6"
            >
                <!-- Header -->
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

                <!-- Table -->
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
                                    class="px-4 py-3 text-right font-semibold text-gray-600"
                                >
                                    Total
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            <tr
                                v-for="reservation in dashboard.latestReservations"
                                :key="reservation.id"
                                class="hover:bg-gray-50 transition"
                            >
                                <td class="px-4 py-4 font-medium text-gray-700">
                                    RES-{{ reservation.id }}
                                </td>

                                <td class="px-4 py-4">
                                    {{ reservation.user.name }}
                                </td>

                                <td class="px-4 py-4">
                                    {{ reservation.room_unit.room_number }}
                                </td>

                                <td class="px-4 py-4">
                                    {{
                                        new Date(
                                            reservation.check_in,
                                        ).toLocaleDateString("id-ID", {
                                            day: "2-digit",
                                            month: "short",
                                            year: "numeric",
                                        })
                                    }}
                                </td>

                                <td class="px-4 py-4">
                                    {{
                                        new Date(
                                            reservation.check_out,
                                        ).toLocaleDateString("id-ID", {
                                            day: "2-digit",
                                            month: "short",
                                            year: "numeric",
                                        })
                                    }}
                                </td>

                                <td class="px-4 py-4 text-center">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold"
                                        :class="{
                                            'bg-yellow-100 text-yellow-700':
                                                reservation.status ===
                                                'pending',

                                            'bg-green-100 text-green-700':
                                                reservation.status ===
                                                'confirmed',

                                            'bg-blue-100 text-blue-700':
                                                reservation.status ===
                                                'check_in',

                                            'bg-purple-100 text-purple-700':
                                                reservation.status ===
                                                'completed',

                                            'bg-red-100 text-red-700':
                                                reservation.status ===
                                                'cancelled',
                                        }"
                                    >
                                        {{ reservation.status }}
                                    </span>
                                </td>

                                <td class="px-4 py-4 text-right font-semibold">
                                    Rp
                                    {{
                                        Number(
                                            reservation.total_price,
                                        ).toLocaleString("id-ID")
                                    }}
                                </td>
                            </tr>

                            <tr
                                v-if="dashboard.latestReservations.length === 0"
                            >
                                <td
                                    colspan="7"
                                    class="text-center py-8 text-gray-400"
                                >
                                    Belum ada reservasi.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            s
        </div>
    </div>
</template>
