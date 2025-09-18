import { defineStore } from "pinia";

export const useRoomStore = defineStore("room", {
  state: () => ({
    availableRooms: null,
  }),

  actions: {
    setAvailableRooms(data) {
      this.availableRooms = data;
    },
    clearAvailableRooms() {
      this.availableRooms = null;
    },
  },
});
