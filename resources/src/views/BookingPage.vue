<script setup>
import { ref, computed } from "vue";
import { useRoute, useRouter } from "vue-router";
import api from "../services/api";
import MyReservation from "./MyReservation.vue";

const route = useRoute();
const router = useRouter();

const today = new Date().toISOString().split("T")[0];
console.log(route.query);

const bookingData = ref({
    hotelId: route.query.hotelId,
    name: route.query.name,
    roomId: route.query.roomId,
    checkin: route.query.checkin,
    checkout: route.query.checkout,
    guest: route.query.guest,
    room: Number(route.query.room),
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
    return (
        bookingData.value.pricePerNight *
        dayBooked.value *
        bookingData.value.room
    );
});

const confirmBooking = async () => {
    try {
        //make reservation
        const reservation = await api.post("/reservations", {
            hotel_id: bookingData.value.hotelId,
            room_id: bookingData.value.roomId,
            check_in: bookingData.value.checkin,
            check_out: bookingData.value.checkout,
            guests: bookingData.value.guest,
            room_count: bookingData.value.room,
        });

        // Buat transaksi payment
        const payment = await api.post("payments", {
            reservation_id: reservation.data.reservation.id,
        });

        console.log(payment.data);

        const snapToken = payment.data.snap_token;

        window.snap.pay(payment.data.token, {
            onSuccess(result) {
                console.log(result);
                router.push("/my-reservations");
            },

            onPending(result) {
                console.log(result);
                router.push("/my-reservations");
            },

            onError(result) {
                console.log(result);
                alert("Pembayaran gagal");
            },

            onClose() {
                router.push("/my-reservations");
            },
        });
    } catch (err) {
        console.error(err.message);
    }
};
</script>

<template>
    <div
        class="max-w-2xl mx-auto mt-10 bg-white shadow-lg rounded-lg p-6 center text-black"
    >
        <h1 class="text-2xl font-bold mb-6">Detail Booking</h1>

        <div class="space-y-3">
            <p>
                <span class="font-semibold">Nama Kamar:</span>
                {{ bookingData.name }}
            </p>
            <p>
                <span class="font-semibold">Check-in:</span>
                {{ bookingData.checkin }}
            </p>
            <p>
                <span class="font-semibold">Check-out:</span>
                {{ bookingData.checkout }}
            </p>
            <p>
                <span class="font-semibold">Jumlah Tamu:</span>
                {{ bookingData.guest }} orang
            </p>
            <p>
                <span class="font-semibold">Jumlah Kamar:</span>
                {{ bookingData.room }} kamar
            </p>
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
                    <input
                        v-model="bookingData.checkin"
                        type="date"
                        class="border rounded px-2 py-1 w-full"
                        :min="today"
                    />
                </label>
                <label>
                    Check-out:
                    <input
                        v-model="bookingData.checkout"
                        type="date"
                        class="border rounded px-2 py-1 w-full"
                        :min="bookingData.checkin"
                    />
                </label>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button
                @click="confirmBooking"
                class="bg-blue-400 text-white px-4 py-2 rounded hover:bg-blue-700"
            >
                Bayar
            </button>
        </div>
    </div>
</template>
