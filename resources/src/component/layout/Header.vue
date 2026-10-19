<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { Bell, Search } from "lucide-vue-next";
import SidebarTrigger from "./sidebar/SidebarTrigger.vue";

const tanggal = ref("");
const time = ref("");

function updateTime() {
    const date = new Date();

    tanggal.value = date.toLocaleDateString("id-ID", {
        weekday: "long",
        day: "numeric",
        month: "long",
        year: "numeric",
        timeZone: "Asia/Jakarta",
    });

    time.value =
        date.toLocaleTimeString("id-ID", {
            hour: "2-digit",
            minute: "2-digit",
            timeZone: "Asia/Jakarta",
        }) + " WIB";
}

let interval;

onMounted(() => {
    updateTime();
    interval = setInterval(updateTime, 60000);
});

onUnmounted(() => {
    clearInterval(interval);
});
</script>

<template>
    <header class="border-b border-gray-100 bg-white px-4 py-4 text-gray-800 md:px-6">
        <div class="flex items-center justify-between gap-3">
            <!-- Hamburger: hanya tampil di mobile -->
            <SidebarTrigger />

            <!-- Search: sembunyi di mobile -->
            <div class="hidden w-full max-w-md flex-1 md:block">
                <div class="relative">
                    <Search class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-500" />
                    <input type="text" placeholder="Cari reservasi, tamu, atau kamar"
                        class="w-full rounded-lg bg-gray-100 py-2 pl-10 pr-4 text-gray-800 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>
            </div>

            <div class="ml-auto flex items-center gap-3 md:gap-4">
                <button type="button" class="relative rounded-lg p-2 transition-colors hover:bg-gray-200">
                    <Bell class="h-5 w-5 text-gray-700" />
                    <span class="absolute right-1 top-1 h-2 w-2 rounded-full bg-red-500"></span>
                </button>

                <div class="hidden text-right md:block">
                    <p class="text-sm text-gray-700">{{ tanggal }}</p>
                    <p class="text-xs text-gray-500">{{ time }}</p>
                </div>
            </div>
        </div>
    </header>
</template>
