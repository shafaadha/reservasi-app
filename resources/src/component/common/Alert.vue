<script setup>
import { faCircleCheck, faCircleInfo } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { info } from "autoprefixer";
import { computed } from "vue";

defineProps({
    type: {
        type: String,
        default: "success",
    },
    title: {
        type: String,
        default: "",
    },
    message: {
        type: String,
        required: true,
    },
});

const icons = {
    success: faCircleCheck,
    info: faCircleInfo,
};

const currentIcon = computed(() => icons[props.type]);
</script>

<template>
    <div
        class="flex flex-row rounded-lg border p-4"
        :class="{
            'border-green-600 bg-green-50 text-green-700': type === 'success',
            'border-red-500 bg-rose-100': type === 'error',
            'border-amber-500 bg-orange-100': type === 'warning',
            'border-blue-400 bg-blue-50': type === 'info',
        }"
    >
        <div>
            <FontAwesomeIcon :icon="currentIcon" />
        </div>
        <div class="flex flex-col gap-4">
            <p v-if="title" class="font-semibold text-gray-800">
                {{ title }}
            </p>

            <p class="text-slate-500">{{ message }}</p>
        </div>
    </div>
</template>
