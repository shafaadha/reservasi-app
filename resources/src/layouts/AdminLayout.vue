<script setup>
import Sidebar from "../component/sidebar/Sidebar.vue";
import SideBarProvider from "../component/sidebar/SideBarProvider.vue";
import SidebarTrigger from "../component/SidebarTrigger.vue";
</script>

<template>
    <SidebarProvider>
        <Sidebar>
            <div class="p-4 font-bold border-b">My Sidebar</div>

            <div class="p-4 space-y-2">
                <a href="#" class="block hover:text-blue-600">Dashboard</a>
                <a href="#" class="block hover:text-blue-600">Products</a>
                <a href="#" class="block hover:text-blue-600">Reports</a>
            </div>
        </Sidebar>

        <div class="flex-1 p-6">
            <div class="flex items-center gap-3 mb-4">
                <SidebarTrigger />
                <h1 class="text-xl font-bold">Dashboard</h1>
            </div>

            <p>Konten utama...</p>
        </div>
    </SidebarProvider>
</template>
