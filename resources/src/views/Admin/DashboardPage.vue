<script setup>
import StatCard from "../../component/card/StatCard.vue";
import { CalendarDaysIcon, CurrencyDollarIcon } from "@heroicons/vue/16/solid";
import api from "../../services/api.js";
import axios from "axios";
import { onMounted, ref } from "vue";

const dataDashboard = ref([]);

const chartOptions = {
    chart: {
        toolbar: {
            show: false,
        },
    },

    title: {
        text: "Reservasi 7 Hari Terakhir",
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

    xaxis: {
        categories: ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"],
    },

    tooltip: {
        enabled: true,
    },

    grid: {
        strokeDashArray: 4,
    },
};

const series = [
    {
        name: "series-1",
        data: [30, 40, 35, 50, 49, 60, 70, 91],
    },
];

onMounted(async () => {
    try {
        const response = await api.get("dashboard");
        roomUnit.value = response.data.data;
    } catch (error) {
        console.log(error);
    }
});
</script>

<template>
    <div>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
            <!-- Cards -->
            <StatCard
                title="Total Reservasi Hari Ini"
                :icon="CalendarDaysIcon"
                value="100"
            />
            <StatCard
                title="Total Reservasi Hari Ini"
                :icon="CalendarDaysIcon"
                value="100"
            />
            <StatCard
                title="Total Reservasi Hari Ini"
                :icon="CalendarDaysIcon"
                value="100"
            />
            <StatCard
                title="Pendapatan Hari Ini"
                :icon="CurrencyDollarIcon"
                value="100"
            />

            <!-- Charts -->
            <div class="col-span-1 md:col-span-2 xl:col-span-2 h-64 rounded-lg">
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
        </div>
    </div>
</template>
