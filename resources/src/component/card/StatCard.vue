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
            'bg-white rounded-lg p-5',
            'shadow-md',
            // 'hover:shadow-xl',
            // 'hover:-translate-y-1',
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
            flex: 1;
        "
    >
        <div
            style="
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
            "
        >
            <span
                style="
                    font-size: 14px;
                    color: #6b7280;
                    line-height: 1.4;
                    max-width: 70%;
                "
                >{{ title }}</span
            >
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
            style="
                font-size: 28px;
                font-weight: 700;
                color: #111827;
                line-height: 1.2;
            "
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
