<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { Bell, Search } from "lucide-vue-next";

const tanggal = ref("");
const time = ref("");

function updateTime() {
    const date = new Date();

    tanggal.value = date.toLocaleDateString("id-ID", {
        weekday: "long",
        day: "numeric",
        month: "long",
        year: "numeric",
    });

    time.value =
        date.toLocaleTimeString("id-ID", {
            hour: "2-digit",
            minute: "2-digit",
            // second: "2-digit",
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
    <div
        class="bg-card border-b border-gray-300 px-6 py-4 bg-white text-gray-800"
    >
        <div class="flex items-center justify-between">
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <Search
                        class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-muted-foreground"
                    />
                    <input
                        type="text"
                        placeholder="Cari reservasi, tamu, atau kamar"
                        class="w-full pl-10 pr-4 py-2 bg-gray-300 border-none rounded-lg text-gray-800 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    />
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button
                    class="relative p-2 hover:bg-gray-200 rounded-lg transition-colors"
                >
                    <Bell class="w-5 h-5 text-foreground" />
                    <span
                        class="absolute top-1 right-1 w-2 h-2 bg-destructive rounded-full"
                    ></span>
                </button>

                <div class="text-right">
                    <p class="text-sm text-foreground">
                        {{ tanggal }}
                    </p>
                    <p class="text-xs text-muted-foreground">{{ time }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
