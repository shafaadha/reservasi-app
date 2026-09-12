<script setup>
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
defineProps({
    title: {
        type: String,
        required: true,
    },
    value: {
        type: [String, Number],
        required: true,
    },
    subtitle: {
        type: String,
        default: "",
    },
    subtitleType: {
        type: String,
        default: "neutral", // "positive" | "negative" | "neutral" | "info"
    },
    icon: {
        type: [Object, Function],
        required: true,
    },
    iconType: {
        type: String,
        default: "hero",
    },
    iconColor: {
        type: String,
        default: "blue", // "blue" | "green" | "purple" | "orange"
    },
    className: {
        type: String,
        default: "",
    },
});

const iconBg = {
    blue: "background: #3b82f6;",
    green: "background: #22c55e;",
    purple: "background: #a855f7;",
    orange: "background: #f97316;",
};

const subtitleColor = {
    positive: "color: #16a34a;",
    negative: "color: #dc2626;",
    neutral: "color: #6b7280;",
    info: "color: #6b7280;",
};
</script>

<template>
    <div
        :class="[
            'w-full min-w-0 bg-white rounded-lg p-4 sm:p-5',
            'shadow-md',
            'transition-all duration-300',
            'cursor-pointer',
        ]"
        style="
            background: #fff;
            border-radius: 14px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            min-width: 0;
        "
    >
        <div class="flex flex-row justify-between">
            <span
                class="max-w-[70%] break-words text-sm leading-[1.4] text-gray-500"
            >
                {{ title }}
            </span>
            <div
                :style="[
                    iconBg[iconColor],
                    'width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;',
                ]"
            >
                <component
                    v-if="iconType === 'hero'"
                    :is="icon"
                    class="w-5 h-5 text-white"
                />

                <FontAwesomeIcon
                    v-else
                    :icon="icon"
                    class="text-white text-lg"
                />
            </div>
        </div>

        <div
            class="break-words text-2xl font-bold leading-tight text-gray-900 sm:text-[28px]"
        >
            {{ value }}
        </div>

        <div
            v-if="subtitle"
            :style="[subtitleColor[subtitleType], 'font-size:13px;']"
        >
            {{ subtitle }}
        </div>
    </div>
</template>
