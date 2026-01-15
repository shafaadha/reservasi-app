import { createRouter, createWebHistory } from "vue-router";
import Login from "../views/Login.vue";
import RoomList from "../views/RoomList.vue";
import MyReservation from "../views/MyReservation.vue";
import Register from "../views/Register.vue";
import About from "../views/About.vue";
import Home from "../views/Home.vue";
import Available from "../views/Available.vue";
import BookingPage from "../views/BookingPage.vue";
import BookingConfirmation from "../views/BookingConfirmation.vue";

const routes = [
    { path: "/login", name: "login", component: Login },
    { path: "/register", name: "register", component: Register },
    { path: "/rooms", name: "rooms", component: RoomList },
    {
        path: "/reservations",
        component: MyReservation,
        meta: { requiresAuth: true },
    },
    { path: "/about", component: About },
    { path: "/", name: "home", component: Home },
    { path: "/rooms/avail", name: "available-room", component: Available },
    {
        path: "/booking",
        name: "BookingPage",
        component: BookingPage,
        meta: { requiresAuth: true },
        props: (route) => ({
            roomId: route.query.roomId,
            checkin: route.query.checkin,
            checkout: route.query.checkout,
            guest: route.query.guest,
        }),
    },
    {
        path: "/confirmation",
        name: "confirmation",
        component: BookingConfirmation,
    },
    {
        path: "/my-reservations",
        name: "myReser",
        component: MyReservation,
        meta: { requiresAuth: true },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const isLoggedIn = !!localStorage.getItem("token");

    if (to.meta.requiresAuth && !isLoggedIn) {
        next({
            name: "login",
            query: { redirect: to.fullPath },
        });
    } else {
        next();
    }
});

export default router;
