<script setup>
import { computed, ref } from "vue";
import { useSidebar } from "../../../composables/useSidebar";
import { RouterLink, useRouter } from "vue-router";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faEllipsis } from "@fortawesome/free-solid-svg-icons";
import { useAuthStore } from "../../../stores/auth";
import ActionMenu from "../../common/ActionMenu.vue";

const openMenu = ref(false);
const auth = useAuthStore();
const isLoggedIn = computed(() => auth.isLoggedIn);

const { isMobile, openMobile, setOpenMobile } = useSidebar();

function closeMobile() {
    setOpenMobile(false);
}


const props = defineProps({
    side: { type: String, default: "left" },
    menu: { type: Array, default: () => [] },
    user: { type: Object, default: () => ({}) },
});

const menuPosition = ref({
    top: 0,
    left: 0,
});

const toggleMenu = (event) => {
    if (openMenu.value) {
        openMenu.value = false;
        return;
    }

    const rect = event.currentTarget.getBoundingClientRect();

    menuPosition.value = {
        top: rect.top - 50,
        left: rect.left + 25,
    };

    openMenu.value = true;
};

async function logOut() {
    try {
        const token = localStorage.getItem("token");

        await api.post(
            "/logout",
            {},
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            },
        );
    } catch (e) {
        console.log(e);
        console.warn("Logout API gagal");
    } finally {
        localStorage.removeItem("token");
        setAuthToken(null);
        isLoggedIn.value = false;
        window.location.reload();
    }
}

const getActionItems = () => [
    {
        label: "Logout",
        action: () => {
            openMenu.value = false;
            logOut();
        },
        danger: true,
    },
];

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
    <div v-if="isMobile && openMobile" class="fixed inset-0 bg-black/50 z-40" @click="closeMobile"></div>
    <aside class="fixed inset-y-0 z-50 flex w-64 flex-col
           justify-between border-r border-gray-100 bg-white
           transition-transform duration-300 ease-in-out" :class="[
            side === 'left' ? 'left-0' : 'right-0',
            isMobile
                ? openMobile
                    ? 'translate-x-0'
                    : side === 'left'
                        ? '-translate-x-full'
                        : 'translate-x-full'
                : 'translate-x-0',
        ]">
        <!-- TOP -->
        <div class="flex flex-col justify-between">
            <!-- Logo -->
            <div class="flex items-center gap-2 px-6 py-4 font-bold text-lg text-gray-800">
                <span class="text-blue-600"></span>
                <div class="flex flex-col">
                    <h1>Hotel Admin</h1>
                    <p>Management System</p>
                </div>
            </div>

            <!-- Menu -->
            <nav class="flex flex-col gap-3 px-2 py-2 text-gray-600">
                <router-link v-for="item in menu" :key="item.name" :to="item.to"
                    class="flex items-center justify-between px-4 py-2 rounded-lg hover:bg-gray-100"
                    active-class="bg-blue-50 text-blue-600" @click="closeMobile">
                    <div class="flex items-center gap-3">
                        <component :is="item.icon" class="w-5 h-5" />
                        <span>{{ item.name }}</span>
                    </div>

                    <span v-if="item.badge" class="text-xs bg-gray-200 px-2 py-0.5 rounded-full">
                        {{ item.badge }}
                    </span>
                </router-link>
            </nav>
        </div>

        <!-- BOTTOM USER -->
        <div class="flex items-center gap-3 px-4 py-4 border-t border-gray-300 text-gray-700">
            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold">
                {{ initials() }}
            </div>
            <div class="text-sm text-gray-600">
                <p class="font-semibold">{{ user.name || "Guest" }}</p>
                <p class="text-gray-500 text-xs">{{ user.email }}</p>
            </div>
            <div>
                <button type="button" @click="toggleMenu($event)"
                    class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                    <FontAwesomeIcon :icon="faEllipsis" />
                </button>
            </div>
            <ActionMenu v-if="openMenu" :items="getActionItems()" :position="menuPosition" />
        </div>
    </aside>


</template>
