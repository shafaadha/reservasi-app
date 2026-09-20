<script setup>
import { computed } from "vue";

const props = defineProps({
    status: {
        type: String,
        required: true,
    },
});

const classes = computed(
    () =>
        ({
            pending: "bg-yellow-100 text-yellow-700",
            confirmed: "bg-green-100 text-green-700",
            check_in: "bg-blue-100 text-blue-700",
            completed: "bg-purple-100 text-purple-700",
            cancelled: "bg-red-100 text-red-700",
            paid: "bg-green-100 text-green-700",
            expired: "bg-red-100 text-red-700",
            failed: "bg-red-100 text-red-700",
        })[props.status] || "bg-gray-100 text-gray-700",
);

const label = computed(() =>
    props.status
        ?.replace(/_/g, " ")
        .replace(/\b\w/g, (char) => char.toUpperCase()),
);
</script>

<template>
    <span class="px-3 py-1 rounded-full text-xs font-semibold" :class="classes">
        {{ label }}
    </span>
</template>
