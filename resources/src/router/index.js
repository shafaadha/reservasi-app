import { createRouter, createWebHistory } from "vue-router";
import Login from "../views/Login.vue";
import RoomList from "../views/RoomList.vue";
import MyReservation from "../views/MyReservation.vue";
import Register from "../views/Register.vue";
import About from "../views/About.vue";
import Home from "../views/Home.vue";
import Available from "../views/Available.vue";

const routes = [
    { path: "/login", name: "login", component: Login },
    { path: "/register", name: "register", component: Register },
    { path: "/rooms", name: "rooms", component: RoomList },
    { path: "/reservations", component: MyReservation },
    { path: "/about", component: About },
    { path: "/", name: "home", component: Home },
    { path: "/rooms/avail", name: "available-room", component: Available },
    {
        path: "/booking",
        name: "BookingPage",
        component: BookingPage,
        props: (route) => ({
            roomId: route.query.roomId,
            checkin: route.query.checkin,
            checkout: route.query.checkout,
            guest: route.query.guest,
        }),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
