<script setup>
import { ref, onMounted } from "vue";
import { useAuthStore } from "../../stores/auth";
import api from "../../services/api";

const auth = useAuthStore();

const rooms = ref([]);
const loading = ref(true);
const page = ref(1);
const lastPage = ref(0);

const getRoom = async () => {
    try {
        loading.value = true;

        const { data } = await api.get("/hotel/roomunits", {
            params: {
                page: page.value,
            },
        });

        rooms.value = data.data.data;

        lastPage.value = data.data.last_page;
    } catch (error) {
        console.error(error);
    } finally {
        loading.value = false;
    }
};

onMounted(async () => {
    await auth.fetchUser();
    await getRoom();
});
</script>

<template>
    <div>
        <div v-if="loading" class="text-black">Loading...</div>

        <div v-else class="">
            <h1>Room List</h1>
            <div
                class="flex flex-row border border-gray-500 rounded-lg justify-between"
            >
                <div
                    v-for="room in rooms"
                    :key="room.id"
                    class="m-2 p-2 text-gray-800 rounded-lg"
                    :class="
                        room.status === 'available'
                            ? 'bg-cyan-500'
                            : 'bg-red-500'
                    "
                >
                    <div class="flex flex-col justify-items-start">
                        <div>Room {{ room.room_number }}</div>
                        <div>
                            {{ room.status }}
                        </div>
                        <div>
                            {{ room.room.type }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
