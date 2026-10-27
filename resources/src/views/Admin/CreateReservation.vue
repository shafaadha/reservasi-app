<script setup>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import BaseInput from '../../component/common/BaseInput.vue';
import { faBroom } from '@fortawesome/free-solid-svg-icons';
import BaseSelect from '../../component/common/BaseSelect.vue';

</script>
<template>
    <div>
        <div class="rounded-lg border-gray-100 text-gray-700">
            <h1 class="text-bold">Create Reservation</h1>
            <div class="mb-8 rounded-2xl bg-white p-5 shadow-sm sm:p-6">
                <!-- Header -->
                <div class="mb-6 flex items-center gap-3">
                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                        <FontAwesomeIcon :icon="faBroom" class="text-lg" />
                    </div>

                    <div>
                        <h2 class="font-semibold text-gray-800">
                            Reservation Detail
                        </h2>
                        <p class="text-sm text-gray-500">
                            Enter the guest's personal information
                        </p>
                    </div>
                </div>

                <!-- Form -->
                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            Check-In
                        </label>
                        <input v-model="checkin" type="date" id="checkin" :min="today"
                            class="border border-stone-200 rounded-lg px-3 py-2.5 text-sm text-stone-700 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 transition-colors" />
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            Check-Out
                        </label>
                        <div>
                            <input v-model="checkout" type="date" id="checkout" :min="minCheckout"
                                class="border border-stone-200 rounded-lg px-3 py-2.5 text-sm text-stone-700 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 transition-colors" />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            Adult
                        </label>
                        <div>
                            <QuantityPicker v-model="guest" :min-value="1" :max-value="10"></QuantityPicker>
                        </div>
                    </div>


                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            Room Type
                        </label>
                        <div>
                            <BaseSelect></BaseSelect>
                        </div>
                    </div>


                </div>
            </div>

            <!-- Guest Information -->
            <div class="mb-8 rounded-2xl bg-white p-5 shadow-sm sm:p-6">
                <div class="mb-6 flex items-center gap-3">
                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                        <FontAwesomeIcon :icon="faUser" class="text-lg" />
                    </div>

                    <div>
                        <h2 class="font-semibold text-gray-800">
                            Guest Information
                        </h2>
                        <p class="text-sm text-gray-500">
                            Enter the guest's personal information
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            Full Name
                        </label>
                        <BaseInput v-model="fullName" placeholder="Example: Shafa Aulia" />
                    </div>

                    <!-- Phone Number -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            Phone Number
                        </label>
                        <BaseInput v-model="phoneNumber" placeholder="81234567890" type="tel" />
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            Email Address
                        </label>
                        <BaseInput v-model="email" placeholder="guest@example.com" type="email" />
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            Identification Number
                        </label>
                        <BaseInput v-model="passport" placeholder="KTP / Passport number" />
                    </div>
                </div>
            </div>


            <!-- Detail menginap -->



        </div>
        <div class="bg-white">

        </div>
    </div>


</template>
