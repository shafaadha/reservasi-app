<script setup>
defineProps({
    className: {
        type: String,
        default: "",
    },
    as: {
        type: String,
        default: "h4",
        validator: (v) => ["h1", "h2", "h3", "h4", "h5", "h6"].includes(v),
    },
    size: {
        type: String,
        default: "md",
        validator: (v) => ["sm", "md", "lg"].includes(v),
    },
    divider: {
        type: Boolean,
        default: false,
    },
});

const sizeClass = {
    sm: "text-sm font-medium",
    md: "text-base font-semibold",
    lg: "text-lg font-semibold",
};
</script>

<template>
    <component
        :is="as"
        :class="[
            'leading-tight tracking-tight text-gray-900',
            sizeClass[size],
            divider && 'pb-2 border-b border-gray-200',
            className,
        ]"
    >
        <slot />
    </component>
</template>
