<script setup>
import { reactive, onMounted } from "vue";
import Sidebar from "../component/sidebar/Sidebar.vue";
import SideBarProvider from "../component/sidebar/SideBarProvider.vue";
import Header from "../component/Header.vue";
import { useAuthStore } from "../stores/auth";

const auth = useAuthStore();

const menuItems = [
    { name: "Dashboard", icon: "🏠" },
    { name: "Orders", icon: "📦", badge: 5 },
    { name: "Schedules", icon: "📅", active: true },
    { name: "Messages", icon: "💬", badge: 3 },
    { name: "Inbox", icon: "📥" },
];

onMounted(async () => {
    try {
        await auth.fetchUser();
        console.log("USER:", auth.user);
    } catch (e) {
        console.log("ERROR FETCH USER:", e);
    }
});
</script>

<template>
    <SideBarProvider>
        <!-- SIDEBAR -->
        <Sidebar :menu="menuItems" :user="auth.user" />

        <!-- CONTENT -->
        <div class="ml-64 flex flex-col min-h-screen">
            <!-- HEADER -->
            <Header />

            <!-- MAIN -->
            <main class="p-6">
                <router-view />
            </main>
        </div>
    </SideBarProvider>
</template>
