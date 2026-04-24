<script setup>
import { computed } from "vue";
import { useSidebar } from "../../composables/useSidebar";

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
                class="flex items-center gap-2 px-6 py-4 font-bold text-lg border-b border-gray-300"
            >
                <span class="text-blue-600"></span>
                <div class="flex flex-col">
                    <h1>Hotel Admin</h1>
                    <p>Management System</p>
                </div>
            </div>

            <!-- Menu -->
            <nav class="flex flex-col gap-1 px-2">
                <div
                    v-for="item in menu"
                    :key="item.name"
                    class="flex items-center justify-between px-4 py-2 rounded-lg cursor-pointer hover:bg-gray-400"
                    :class="item.active ? 'bg-blue-500 text-white' : ''"
                >
                    <div class="flex items-center gap-3 text-gray">
                        <span>{{ item.icon }}</span>
                        <span>{{ item.name }}</span>
                    </div>

                    <span
                        v-if="item.badge"
                        class="text-xs bg-gray-200 px-2 py-0.5 rounded-full"
                    >
                        {{ item.badge }}
                    </span>
                </div>
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
