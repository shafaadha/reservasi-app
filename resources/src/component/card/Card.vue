<script setup>
import CardTitle from "./CardTitle.vue";

defineProps({
    title: {
        type: String,
        default: "",
    },
    description: {
        type: String,
        default: "",
    },
    variant: {
        type: String,
        default: "default",
        validator: (v) => ["default", "outlined", "flat"].includes(v),
    },
    padding: {
        type: String,
        default: "md",
        validator: (v) => ["sm", "md", "lg", "none"].includes(v),
    },
    className: {
        type: String,
        default: "",
    },
});

const variantClass = {
    default: "bg-white border border-gray-200 shadow-sm",
    outlined: "bg-transparent border border-gray-300",
    flat: "bg-gray-50",
};

const paddingClass = {
    none: "",
    sm: "p-3",
    md: "p-5",
    lg: "p-7",
};
</script>

<template>
    <div
        :class="[
            'rounded-xl',
            variantClass[variant],
            paddingClass[padding],
            className,
        ]"
    >
        <div v-if="$slots.header || title" class="mb-3">
            <slot name="header">
                <CardTitle
                    :divider="!!($slots.default || description)"
                    size="md"
                >
                    {{ title }}
                </CardTitle>
                <p v-if="description" class="mt-1 text-sm text-gray-500">
                    {{ description }}
                </p>
            </slot>
        </div>

        <slot />

        <div v-if="$slots.footer" class="mt-4 pt-3 border-t border-gray-100">
            <slot name="footer" />
        </div>
    </div>
</template>
