<script setup>
const props = defineProps({
    modelValue: { type: Number, default: 1 },
    minValue: { type: Number, default: 1 },
    maxValue: { type: Number, default: 99 },
});

const emit = defineEmits(["update:modelValue"]);

const decrease = () => {
    if (props.modelValue > props.minValue) {
        emit("update:modelValue", props.modelValue - 1);
    }
};

const increase = () => {
    if (props.modelValue < props.maxValue) {
        emit("update:modelValue", props.modelValue + 1);
    }
};
</script>

<template>
    <div
        class="flex flex-row items-center w-full h-[42px] text-gray-700 border border-stone-200 rounded-lg overflow-hidden"
    >
        <button
            type="button"
            @click="decrease"
            class="w-10 h-full flex items-center justify-center border-r border-stone-200"
        >
            -
        </button>

        <span class="flex-1 text-center text-sm">
            {{ modelValue }}
        </span>

        <button
            type="button"
            @click="increase"
            class="w-10 h-full flex items-center justify-center border-l border-stone-200"
        >
            +
        </button>
    </div>
</template>
