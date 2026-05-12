// src/stores/auth.js
import { defineStore } from "pinia";
import api, { setAuthToken } from "../services/api";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        user: null,
        token: localStorage.getItem("token") || null,
    }),

    getters: {
        isLoggedIn: (state) => !!state.token,
        userId: (state) => state.user?.id,
        userRole: (state) => state.user?.role,
    },

    actions: {
        async login(credentials) {
            const res = await api.post("/login", credentials);

            this.token = res.data.token;

            localStorage.setItem("token", this.token);

            setAuthToken(this.token);

            try {
                await this.fetchUser();
            } catch (err) {
                console.log("FETCH USER ERROR:", err);
            }
        },

        async fetchUser() {
            try {
                const res = await api.get("/user");
                this.user = res.data;
            } catch (err) {
                console.log("USER ERROR:", err.response);
                console.log(err.response?.status);
                console.log(err.response?.data);

                this.user = null;
                this.token = null;
                localStorage.removeItem("token");

                throw err;
            }
        },

        logout() {
            this.user = null;
            this.token = null;

            localStorage.removeItem("token");

            setAuthToken(null);
        },
    },
});
