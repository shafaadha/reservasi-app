<script setup>
import { computed } from "vue";

const props = defineProps({
    modelValue: { type: Object, required: true },
    minLimit: { type: Number, default: 0 },
    maxLimit: { type: Number, default: 5000000 },
    gap: { type: Number, default: 50000 },
    step: { type: Number, default: 10000 }
});

const emit = defineEmits(["update:modelValue"]);

const minPrice = computed({
    get: () => props.modelValue?.min ?? props.minLimit,
    set: (val) => {
        if ((props.modelValue.max - val) < props.gap) {
            val = props.modelValue.max - props.gap;
        }
        emit("update:modelValue", {
            ...props.modelValue,
            min: Number(val)
        });
    }
});

const maxPrice = computed({
    get: () => props.modelValue?.max ?? props.maxLimit,
    set: (val) => {
        if ((val - props.modelValue.min) < props.gap) {
            val = props.modelValue.min + props.gap;
        }
        emit("update:modelValue", {
            ...props.modelValue,
            max: Number(val)
        });
    }
});
</script>

<template>
    <div>
        <div class="flex justify-between mb-2 text-sm font-medium">
            <span>Rp {{ Number(minPrice).toLocaleString("id-ID") }}</span>
            <span>Rp {{ Number(maxPrice).toLocaleString("id-ID") }}</span>
        </div>

        <div class="relative h-1 bg-gray-300 rounded">
            <div class="absolute h-1 bg-cyan-800 rounded" :style="{
                left: ((minPrice / maxLimit) * 100) + '%',
                right: (100 - (maxPrice / maxLimit) * 100) + '%'
            }"></div>

            <input type="range" :min="minLimit" :max="maxLimit" :step="step" v-model="minPrice"
                class="absolute w-full h-1 bg-neutral-quaternary accent-cyan-500 slider-thumb rounded-full cursor-pointer" />

            <input type="range" :min="minLimit" :max="maxLimit" :step="step" v-model="maxPrice"
                class="absolute w-full h-1 bg-neutral-quaternary accent-cyan-500 slider-thumb rounded-full cursor-pointer" />
        </div>
    </div>
</template>

<style scoped>
input[type="range"]::-webkit-slider-thumb {
    width: 16px;
    height: 16px;
    background: #25cdeb;
    border-radius: 50%;
    cursor: pointer;
    appearance: none;
}
</style>
