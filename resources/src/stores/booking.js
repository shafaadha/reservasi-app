import { defineStore } from "pinia";

export const useBookingStore = defineStore("booking", {
    state: () => ({
        pendingBooking: null,
    }),

    actions: {
        setPendingBooking(data) {
            this.pendingBooking = data;
        },

        clearPendingBooking() {
            this.pendingBooking = null;
        },
    },
});
