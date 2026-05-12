<script setup>
import StatCard from "../../component/card/StatCard.vue";

import { CalendarDaysIcon } from "@heroicons/vue/16/solid";
</script>

<template>
    <div>
        <div class="grid grid-cols-4 gap-3">
            <div>
                <StatCard
                    title="Total Reservasi Hari Ini"
                    :icon="CalendarDaysIcon"
                    value="100"
                ></StatCard>
            </div>
            <div>
                <StatCard
                    title="Total Reservasi Hari Ini"
                    :icon="CalendarDaysIcon"
                    value="100"
                ></StatCard>
            </div>
            <div>
                <StatCard
                    title="Total Reservasi Hari Ini"
                    :icon="CalendarDaysIcon"
                    value="100"
                ></StatCard>
            </div>
            <div>
                <StatCard
                    title="Total Reservasi Hari Ini"
                    :icon="CalendarDaysIcon"
                    value="100"
                ></StatCard>
            </div>
        </div>
    </div>
</template>
