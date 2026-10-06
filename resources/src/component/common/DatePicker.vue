<template>
    <div class="w-full md:w-2/3 flex flex-col sm:flex-row items-center gap-3">
        <div class="w-full flex flex-col gap-1.5">
            <label
                class="text-xs font-semibold text-gray-500 uppercase tracking-wider"
                >Start Date</label
            >
            <input
                type="date"
                v-model="startDate"
                :max="endDate"
                class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-700 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 cursor-pointer"
            />
        </div>

        <!-- Arrow Divider -->
        <div class="hidden sm:block text-gray-400 self-end mb-2.5">
            <svg
                xmlns="http://w3.org"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke="currentColor"
                class="w-4 h-4"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"
                />
            </svg>
        </div>
        <div class="w-full flex flex-col gap-1.5">
            <label
                class="text-xs font-semibold text-gray-500 uppercase tracking-wider"
                >End Date</label
            >
            <input
                type="date"
                v-model="endDate"
                :min="startDate"
                class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-700 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 cursor-pointer"
            />
        </div>
        <button
            v-if="startDate || endDate"
            @click="clearDates"
            class="w-full sm:w-auto px-3 py-2 self-end mb-0.5 text-sm font-medium text-rose-600 bg-rose-50 border border-rose-100 rounded-lg hover:bg-rose-100 transition whitespace-nowrap"
        >
            Clear Dates
        </button>
    </div>
</template>

<script setup>
const startDate = defineModel("start", { type: String, default: "" });
const endDate = defineModel("end", { type: String, default: "" });

const clearDates = () => {
    startDate.value = "";
    endDate.value = "";
};
</script>
