import "../src/assets/main.css";
import "../css/app.css";

import { createApp } from "vue";
import { createPinia } from "pinia";

import PrimeVue from "primevue/config";
import Aura from "@primeuix/themes/aura";

import App from "../src/App.vue";
import router from "../src/router/index.js";

import Button from "primevue/button";
import InputText from "primevue/inputtext";

import * as HeroIconsOutline from "@heroicons/vue/24/outline";

import { useAuthStore } from "../src/stores/auth.js";
import { setAuthToken } from "../src/services/api.js";
import VueApexCharts from "vue3-apexcharts";

const app = createApp(App);

const pinia = createPinia();

app.use(pinia);
app.use(VueApexCharts);

const auth = useAuthStore();

if (auth.token) {
    setAuthToken(auth.token);

    try {
        await auth.fetchUser();
    } catch (err) {
        console.log(err);
    }
}

app.use(router);

app.use(PrimeVue, {
    theme: {
        preset: Aura,
    },
});

app.component("Button", Button);
app.component("InputText", InputText);

for (const [key, component] of Object.entries(HeroIconsOutline)) {
    app.component(key, component);
}

app.mount("#app");
