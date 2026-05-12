<script setup>
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
        type: Object,
        required: true,
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
        :class="['stat-card', className]"
        style="
            background: #fff;
            border-radius: 14px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.07);
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
                    :is="icon"
                    style="width: 20px; height: 20px; color: #fff"
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
