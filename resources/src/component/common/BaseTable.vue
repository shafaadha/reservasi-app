<script setup>
defineProps({
    columns: {
        type: Array,
        required: true,
    },
    items: {
        type: Array,
        default: () => [],
    },
    loading: {
        type: Boolean,
        default: false,
    },
    emptyText: {
        type: String,
        default: "Data tidak ditemukan",
    },
    striped: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Header -->
        <div v-if="$slots.header" class="px-6 py-4 border-b">
            <slot name="header" />
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                ...
            </table>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            v-for="column in columns"
                            :key="column.key"
                            :class="[
                                'px-6 py-3 text-xs font-semibold uppercase tracking-wider',
                                column.align ?? 'text-left',
                            ]"
                        >
                            {{ column.label }}
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    <!-- Loading -->
                    <tr v-if="loading">
                        <td
                            :colspan="columns.length"
                            class="py-10 text-center text-gray-500"
                        >
                            Loading...
                        </td>
                    </tr>

                    <!-- Data -->
                    <tr
                        v-else-if="items.length"
                        v-for="(item, index) in items"
                        :key="item.id ?? index"
                        :class="[
                            'transition hover:bg-gray-50',
                            striped && index % 2 ? 'bg-gray-50/40' : '',
                        ]"
                    >
                        <slot name="row" :item="item" :index="index" />
                    </tr>

                    <!-- Empty -->
                    <tr v-else>
                        <td
                            :colspan="columns.length"
                            class="py-10 text-center text-gray-400"
                        >
                            {{ emptyText }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div v-if="$slots.footer" class="border-t px-6 py-4">
            <slot name="footer" />
        </div>
    </div>
</template>
