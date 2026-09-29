<script setup>
import { ref, onMounted, computed } from "vue";
import { useAuthStore } from "../../stores/auth";
import api from "../../services/api";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faBroom } from "@fortawesome/free-solid-svg-icons";

const auth = useAuthStore();

const rooms = ref([]);
const loading = ref(true);
const page = ref(1);
const lastPage = ref(0);

const filteredRooms = computed(() => {
    return rooms.value.filter;
});

const formatDate = (date) => {
    if (!date) return "";

    return new Date(date).toLocaleDateString("id-ID", {
        day: "2-digit",
        month: "2-digit",
    });
};

const getRoom = async () => {
    try {
        loading.value = true;

        const { data } = await api.get("/hotel/roomunits");
        // const { data } = await api.get("/hotel/roomunits", {
        //     params: {
        //         page: page.value,
        //     },
        // });

        rooms.value = data.data;

        lastPage.value = data.data.last_page;
    } catch (error) {
        console.error(error);
    } finally {
        loading.value = false;
    }
};

function firstName(room) {
    const name = room.current_reservation?.[0]?.user?.name;

    if (!name) {
        return "";
    }

    return name.split(" ")[0];
}

onMounted(async () => {
    await auth.fetchUser();
    await getRoom();
});
</script>

<template>
    <div class="grid grid-cols-1">
        <div>
            <div v-if="loading" class="text-black">Loading...</div>

            <div v-else class="text-gray-700">
                <div class="flex flex-row justify-between w-full mb-2">
                    <div class="text-lg text-gray-700">Room List</div>
                    <div class="flex flex-row gap-2">
                        <div
                            class="flex items-center justify-center rounded-full bg-white px-3 py-1 text-xs font-semibold"
                        >
                            Available
                        </div>
                        <div
                            class="flex items-center justify-center rounded-full bg-white px-3 py-1 text-xs font-semibold"
                        >
                            Occupied
                        </div>
                    </div>
                </div>

                <div
                    class="grid grid-cols-6 gap-2 rounded-lg justify-between bg-white"
                >
                    <div
                        v-for="room in rooms"
                        :key="room.id"
                        class="m-2 p-2 text-gray-800 rounded-lg"
                        :class="{
                            'bg-amber-100': room.status === 'available',
                            'bg-red-100': room.status === 'occupied',
                            'bg-yellow-100': room.status === 'maintenance',
                            'bg-blue-100': room.status === 'reserved',
                        }"
                    >
                        <div class="flex w-full flex-col items-start gap-2">
                            <div
                                class="flex w-full flex-row items-center justify-between"
                            >
                                <div
                                    class="flex items-center justify-center rounded-full bg-white px-3 py-0.5 font-semibold text-gray-800"
                                >
                                    {{ room.room_number }}
                                </div>

                                <div
                                    class="flex flex-col text-xs text-gray-800"
                                >
                                    <div>
                                        {{
                                            formatDate(
                                                room.current_reservation?.[0]
                                                    ?.check_in,
                                            )
                                        }}
                                        -
                                        {{
                                            formatDate(
                                                room.current_reservation?.[0]
                                                    ?.check_out,
                                            )
                                        }}
                                    </div>
                                    <div>
                                        {{ firstName(room) }}
                                    </div>
                                </div>
                            </div>

                            <div class="text-sm text-gray-600">
                                {{ room.room.type }}
                            </div>

                            <div class="flex flex-row"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
