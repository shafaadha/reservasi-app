<script setup>
defineProps({
    count: {
        type: Number,
        default: 3,
    },
});
</script>

<template>
    <div class="space-y-4 animate-pulse">
        <div
            v-for="n in count"
            :key="n"
            class="rounded-2xl shadow p-5 border border-gray-200"
        >
            <!-- Header -->
            <div class="flex justify-between items-center mb-4">
                <div class="h-5 w-40 bg-gray-200 rounded"></div>
                <div class="h-6 w-20 bg-gray-200 rounded-full"></div>
            </div>

            <!-- Room -->
            <div class="h-4 w-52 bg-gray-200 rounded mb-5"></div>

            <!-- Footer -->
            <div class="flex justify-between items-center">
                <div>
                    <div class="h-4 w-24 bg-gray-200 rounded mb-2"></div>
                    <div class="h-5 w-32 bg-gray-200 rounded"></div>
                </div>

                <div class="h-10 w-24 bg-gray-200 rounded-lg"></div>
            </div>
        </div>
    </div>
</template>
