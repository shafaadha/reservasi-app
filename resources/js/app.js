import "../src/assets/main.css"
import '../css/app.css'
import { createApp } from "vue";
import {createPinia} from 'pinia';
import PrimeVue from "primevue/config";
import Aura from '@primeuix/themes/aura';
import App from "../src/App.vue";
import router from "../src/router/index.js";
import Button from "primevue/button";
import InputText from "primevue/inputtext";


const app = createApp(App);
app.use(router);
app.use(PrimeVue, {
    theme: {
        preset: Aura,
    }
});
app.use(createPinia());
app.component('Button', Button)
app.component('InputText', InputText);
app.mount('#app');