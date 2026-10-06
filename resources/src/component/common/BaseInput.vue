<script setup>
defineProps({
    modelValue: {
        type: [String, Number],
        default: "",
    },
    type: {
        type: String,
        default: "text",
    },
    placeholder: {
        type: String,
        default: "",
    },
});

defineEmits(["update:modelValue"]);
</script>

<template>
    <input
        :value="modelValue"
        :type="type"
        :placeholder="placeholder"
        @input="$emit('update:modelValue', $event.target.value)"
        class="h-10 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-700 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
    />
</template>
