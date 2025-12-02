<script setup>
import { computed } from "vue";

const props = defineProps({
    modelValue: {
        type: Array,
        required: true
    },
    categories: {
        type: Array,
        required: true
    }
});

const emit = defineEmits(["update:modelValue"]);

const selected = computed({
    get: () => props.modelValue,
    set: (val) => emit("update:modelValue", val)
});
</script>

<template>
    <div>
        <h3 class="font-medium mb-2">Categories</h3>

        <div v-for="cat in categories" :key="cat" class="flex items-center gap-2 mb-1 text-gray-900">
            <input
                type="checkbox"
                :value="cat"
                v-model="selected"
                class="w-4 h-4 accent-cyan-600 rounded-full"
            />
            <label>{{ cat }}</label>
        </div>
    </div>
</template>
