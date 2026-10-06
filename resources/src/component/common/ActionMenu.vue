<script setup>
import { ref } from "vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faEllipsis } from "@fortawesome/free-solid-svg-icons";

defineProps({
    items: {
        type: Array,
        default: () => [],
    },
});

const open = ref(false);
const position = ref({
    top: 0,
    left: 0,
});

const toggle = (event) => {
    if (open.value) {
        open.value = false;
        return;
    }

    const rect = event.currentTarget.getBoundingClientRect();

    position.value = {
        top: rect.bottom + 4,
        left: rect.right - 144,
    };

    open.value = true;
};

const handleAction = (item) => {
    open.value = false;
    item.action();
};
</script>

<template>
    <button
        type="button"
        @click="toggle"
        class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700"
    >
        <FontAwesomeIcon :icon="faEllipsis" />
    </button>

    <Teleport to="body">
        <div
            v-if="open"
            class="fixed z-[9999] w-36 rounded-lg border border-gray-200 bg-white py-1 text-left shadow-lg"
            :style="{
                top: `${position.top}px`,
                left: `${position.left}px`,
            }"
        >
            <button
                v-for="item in items"
                :key="item.label"
                type="button"
                class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-100"
                :class="
                    item.danger
                        ? 'text-red-600 hover:bg-red-50'
                        : 'text-gray-700'
                "
                @click="handleAction(item)"
            >
                {{ item.label }}
            </button>
        </div>
    </Teleport>
</template>
