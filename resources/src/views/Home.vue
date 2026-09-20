<script setup lang="ts">
import { computed, ref } from "vue";
import { useRouter } from "vue-router";
import { faMagnifyingGlass } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import QuantityPicker from "../component/QuantityPicker.vue";
import Alert from "../component/common/Alert.vue";

const router = useRouter();

const checkin = ref("");
const checkout = ref("");
const guest = ref(1);
const room = ref(1);

const errorMessage = ref("");
const loading = ref(false);

const today = new Date();

const tomorrow = new Date(today);
tomorrow.setDate(today.getDate() + 1);

const todayString = today.toISOString().split("T")[0];
const tomorrowString = tomorrow.toISOString().split("T")[0];

const minCheckout = computed(() => {
    if (!checkin.value) return tomorrowString;

    const date = new Date(checkin.value);
    date.setDate(date.getDate() + 1);

    return date.toISOString().split("T")[0];
});

async function handleSearch() {
    errorMessage.value = "";
    loading.value = true;

    try {
        if (!checkin.value || !checkout.value || !guest.value || !room.value) {
            errorMessage.value = "Please fill in all fields.";
            return;
        }

        if (new Date(checkout.value) <= new Date(checkin.value)) {
            errorMessage.value = "Check out must be after check in.";
            return;
        }

        router.push({
            name: "available-room",
            query: {
                checkin: checkin.value,
                checkout: checkout.value,
                guest: guest.value,
                room: room.value,
            },
        });
    } catch (err) {
        errorMessage.value = "Something went wrong. Please try again.";
        console.error(err);
    } finally {
        loading.value = false;
    }
}
</script>

<template>
    <div class="w-full bg-white pb-32">
        <div class="relative h-80">
            <img
                src="../assets/picture/home.jpg"
                alt="home"
                class="absolute inset-0 w-full h-full object-cover opacity-75"
            />

            <!-- Card -->
            <div
                class="absolute left-1/2 bottom-0 transform -translate-x-1/2 translate-y-1/2 z-10 w-full max-w-5xl px-4"
            >
                <!-- Alert -->
                <div
                    v-if="errorMessage"
                    class="mt-4 p-3 rounded-lg bg-red-100 border border-red-300 text-red-700 text-sm text-center"
                >
                    <Alert></Alert>
                </div>
                <form
                    @submit.prevent="handleSearch"
                    class="bg-white rounded-xl shadow-2xl shadow-black/20 px-6 py-6 grid grid-cols-2 md:grid-cols-5 gap-4 items-end"
                >
                    <!-- Check In -->
                    <div class="flex flex-col gap-1.5">
                        <label
                            for="checkin"
                            class="text-sm font-medium text-stone-600 tracking-wider"
                        >
                            Check In
                        </label>

                        <input
                            v-model="checkin"
                            type="date"
                            id="checkin"
                            :min="today"
                            class="border border-stone-200 rounded-lg px-3 py-2.5 text-sm text-stone-700 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 transition-colors"
                        />
                    </div>

                    <!-- Check Out -->
                    <div class="flex flex-col gap-1.5">
                        <label
                            for="checkout"
                            class="text-sm font-medium text-stone-600 tracking-wider"
                        >
                            Check Out
                        </label>

                        <input
                            v-model="checkout"
                            type="date"
                            id="checkout"
                            :min="minCheckout"
                            class="border border-stone-200 rounded-lg px-3 py-2.5 text-sm text-stone-700 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 transition-colors"
                        />
                    </div>

                    <!-- Guest -->
                    <div class="flex flex-col gap-1.5">
                        <label
                            for="guest"
                            class="text-sm font-medium text-stone-600 tracking-wider"
                        >
                            Guest
                        </label>

                        <QuantityPicker
                            v-model="guest"
                            :min-value="1"
                            :max-value="10"
                        ></QuantityPicker>
                    </div>

                    <!-- Room -->
                    <div class="flex flex-col gap-1.5">
                        <label
                            for="room"
                            class="text-sm font-medium text-stone-600 tracking-wider"
                        >
                            Room
                        </label>

                        <QuantityPicker
                            v-model="room"
                            :min-value="1"
                            :max-value="10"
                        ></QuantityPicker>
                    </div>

                    <!-- Button -->
                    <button
                        type="submit"
                        class="bg-blue-500 hover:bg-blue-600 md:col-span-1 col-span-2 text-white rounded-lg py-2.5 px-6 text-sm font-semibold tracking-wide transition-colors duration-200 flex items-center justify-center gap-2 shadow-md"
                    >
                        <FontAwesomeIcon
                            :icon="faMagnifyingGlass"
                            class="w-5"
                        />
                        Search
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
