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
import { Layout } from "lucide-vue-next";
import DashboardPage from "../views/Admin/DashboardPage.vue";
import { useAuthStore } from "../stores/auth";

const routes = [
    { path: "/login", name: "login", component: Login },
    { path: "/register", name: "register", component: Register },
    { path: "/rooms", name: "rooms", component: RoomList },
    {
        path: "/reservations",
        component: MyReservation,
        meta: { requiresAuth: true, layout: "user" },
    },
    { path: "/about", component: About, meta: { layout: "user" } },
    { path: "/", name: "home", component: Home, meta: { layout: "user" } },
    {
        path: "/rooms/avail",
        name: "available-room",
        component: Available,
        meta: { layout: "user" },
    },
    {
        path: "/booking",
        name: "BookingPage",
        component: BookingPage,
        meta: { requiresAuth: true, layout: "user" },
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
        meta: { requiresAuth: true, layout: "user" },
    },
    {
        path: "/admin/dashboard",
        name: "admin",
        component: DashboardPage,
        meta: { requiresAuth: true, layout: "admin", role: "admin" },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    const auth = useAuthStore();

    if (to.path === "/login" || to.path === "/register") {
        return next();
    }

    if (auth.token && !auth.user) {
        try {
            setAuthToken(auth.token);
            await auth.fetchUser();
        } catch (e) {
            return next("/login");
        }
    }

    if (to.meta.requiresAuth && !auth.token) {
        return next("/login");
    }

    if (to.meta.role) {
        const isAdmin = auth.user?.role === "admin";

        if (!isAdmin && auth.user?.role !== to.meta.role) {
            return next("/");
        }
    }

    next();
});

export default router;
