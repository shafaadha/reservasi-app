<script setup>
defineProps({
    columns: {
        type: Array,
        required: true,
    },
    rows: {
        type: Number,
        default: 5,
    },
});
</script>

<template>
    <tr
        v-for="row in rows"
        :key="row"
        class="animate-pulse border-b border-gray-100"
    >
        <td
            v-for="(column, index) in columns"
            :key="index"
            class="px-4 py-4"
            :class="
                column.align === 'center'
                    ? 'text-center'
                    : column.align === 'right'
                      ? 'text-right'
                      : 'text-left'
            "
        >
            <div
                class="h-4 rounded bg-gray-200"
                :class="column.width || 'w-24'"
            ></div>
        </td>
    </tr>
</template>
