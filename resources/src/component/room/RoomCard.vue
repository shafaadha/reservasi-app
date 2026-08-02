<script setup>
const props = defineProps({
    room: {
        type: Object,
        required: true,
    },
    photo: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(["reserve"]);

const reserve = () => {
    emit("reserve", props.room);
};
</script>

<template>
    <div
        class="flex flex-col md:flex-row justify-between items-center border border-gray-200 rounded p-4 mb-3 shadow-sm hover:shadow-md transition-shadow duration-200"
    >
        <img
            v-if="photo"
            :src="photo.urls.small"
            :alt="photo.alt_description"
            class="w-48 h-32 object-cover rounded-md mb-3 md:mb-0 md:mr-4"
        />

        <div class="flex-1">
            <h2 class="font-semibold text-lg">
                {{ room.hotel.name }}
            </h2>

            <p>Tipe: {{ room.type }}</p>
            <p>Kapasitas: {{ room.capacity }} orang</p>
            <p>Jumlah tersedia: {{ room.quantity }}</p>
        </div>

        <div class="text-right mt-3 md:mt-0">
            <div class="text-green-600 font-bold mb-2">
                Rp {{ Number(room.price).toLocaleString("id-ID") }}
            </div>

            <button
                @click="reserve"
                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600"
            >
                Pesan
            </button>
        </div>
    </div>
</template>
