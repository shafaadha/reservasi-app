<script setup>
import { computed } from "vue";
import { useSidebar } from "../../composables/useSidebar";
import { RouterLink, useRouter } from "vue-router";

const props = defineProps({
    side: { type: String, default: "left" },
    menu: { type: Array, default: () => [] },
    user: { type: Object, default: () => ({}) },
});

const { isMobile, openMobile, setOpenMobile } = useSidebar();

function closeMobile() {
    setOpenMobile(false);
}

function initials() {
    const name = props.user?.name || "";
    const words = name.split(" ");

    return (
        (words[0]?.charAt(0).toUpperCase() || "") +
        (words[1]?.charAt(0).toUpperCase() || "")
    );
}
</script>

<template>
    <!-- Overlay (Mobile) -->
    <div
        v-if="isMobile && openMobile"
        class="fixed inset-0 bg-black/50 z-40"
        @click="closeMobile"
    ></div>

    <!-- Sidebar -->
    <aside
        class="fixed inset-y-0 z-50 w-64 bg-white border-r border-gray-300 flex flex-col justify-between transition-all"
        :class="[
            side === 'left' ? 'left-0' : 'right-0',
            isMobile
                ? openMobile
                    ? 'translate-x-0'
                    : '-translate-x-full'
                : '',
        ]"
    >
        <!-- TOP -->
        <div>
            <!-- Logo -->
            <div
                class="flex items-center gap-2 px-6 py-4 font-bold text-lg border-b border-gray-300 text-gray-800"
            >
                <span class="text-blue-600"></span>
                <div class="flex flex-col">
                    <h1>Hotel Admin</h1>
                    <p>Management System</p>
                </div>
            </div>

            <!-- Menu -->
            <nav class="flex flex-col gap-1 px-2 py-2 text-gray-800">
                <router-link
                    v-for="item in menu"
                    :key="item.name"
                    :to="item.to"
                    class="flex items-center justify-between px-4 py-2 rounded-lg hover:bg-gray-100"
                    active-class="bg-indigo-600 text-white"
                    @click="closeMobile"
                >
                    <div class="flex items-center gap-3">
                        <component :is="item.icon" class="w-5 h-5" />
                        <span>{{ item.name }}</span>
                    </div>

                    <span
                        v-if="item.badge"
                        class="text-xs bg-gray-200 px-2 py-0.5 rounded-full"
                    >
                        {{ item.badge }}
                    </span>
                </router-link>
            </nav>
        </div>

        <!-- BOTTOM USER -->
        <div class="flex items-center gap-3 px-4 py-4 border-t border-gray-300">
            <div
                class="w-10 h-10 rounded-full flex items-center justify-center font-bold"
            >
                {{ initials() }}
            </div>
            <div class="text-sm">
                <p class="font-semibold">{{ user.name || "Guest" }}</p>
                <p class="text-gray-500 text-xs">{{ user.email }}</p>
            </div>
        </div>
    </aside>
</template>
