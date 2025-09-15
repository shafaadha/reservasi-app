import { createRouter, createWebHistory } from "vue-router";
import Login from "../views/Login.vue";
import RoomList from "../views/RoomList.vue";
import MyReservation from "../views/MyReservation.vue";
import Register from "../views/Register.vue";
import About from "../views/About.vue";
import Home from "../views/Home.vue";


const routes = [
    { path: "/login", name: "login", component: Login },
    { path: "/register", name: "register", component: Register },
    { path: "/rooms", name: "rooms", component: RoomList },
    { path: "/reservations", component: MyReservation },
    { path: "/about", component: About },
    { path: "/home", component: Home}
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
