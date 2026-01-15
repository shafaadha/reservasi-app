<script setup>
import { ref, computed } from "vue";
import { useRoute, useRouter } from "vue-router";
import api from "../services/api";

const route = useRoute();
const router = useRouter();

const today = new Date().toISOString().split("T")[0];

const bookingData = ref({
    name: route.query.name,
    roomId: route.query.roomId,
    checkin: route.query.checkin,
    checkout: route.query.checkout,
    guest: route.query.guest,
    pricePerNight: Number(route.query.price),
});

const dayBooked = computed(() => {
    if (!bookingData.value.checkin || !bookingData.value.checkout) return 0;

    const diffTime =
        new Date(bookingData.value.checkout) -
        new Date(bookingData.value.checkin);

    const days = Math.floor(diffTime / (1000 * 60 * 60 * 24));
    return days > 0 ? days : 0;
});

const totalPrice = computed(() => {
    return bookingData.value.pricePerNight * dayBooked.value;
});

const confirmBooking = async () => {
    try {
        const res = await api.post("/reservations", {
            hotel_id: route.query.roomId,
            room_id: bookingData.value.roomId,
            check_in: bookingData.value.checkin,
            check_out: bookingData.value.checkout,
            guests: bookingData.value.guest,
            room_booked: dayBooked.value,
            total_price: totalPrice.value,
        });

        router.push({
            name: "confirmation",
            query: { id: res.data.reservation.id },
        });
    } catch (err) {
        console.error(err);
        alert("Gagal booking");
    }
};
</script>


<template>
    <div class="max-w-2xl mx-auto mt-10 bg-white shadow-lg rounded-lg p-6 center">
        <h1 class="text-2xl font-bold mb-6">Detail Booking</h1>

        <div class="space-y-3">
            <p><span class="font-semibold">Nama Kamar:</span> {{ bookingData.name }}</p>
            <p><span class="font-semibold">Check-in:</span> {{ bookingData.checkin }}</p>
            <p><span class="font-semibold">Check-out:</span> {{ bookingData.checkout }}</p>
            <p><span class="font-semibold">Jumlah Tamu:</span> {{ bookingData.guest }} orang</p>
            <p>
                <span class="font-semibold">Total Malam:</span>
                {{ dayBooked }} malam
            </p>

            <p>
                <span class="font-semibold">Harga:</span>
                Rp {{ Number(totalPrice).toLocaleString("id-ID") }}
            </p>
        </div>

        <div class="mt-6 border-t pt-4">
            <h2 class="text-lg font-semibold mb-3">Ubah Tanggal</h2>
            <div class="flex flex-col gap-3">
                <label>
                    Check-in:
                    <input v-model="bookingData.checkin" type="date" class="border rounded px-2 py-1 w-full"
                        :min="today" />
                </label>
                <label>
                    Check-out:
                    <input v-model="bookingData.checkout" type="date" class="border rounded px-2 py-1 w-full"
                        :min="bookingData.checkin" />
                </label>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button @click="confirmBooking" class="bg-blue-400 text-white px-4 py-2 rounded hover:bg-blue-700">
                Konfirmasi Booking
            </button>
        </div>
    </div>
</template>
