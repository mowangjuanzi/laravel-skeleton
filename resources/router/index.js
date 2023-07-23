import {createRouter, createWebHashHistory} from "vue-router";
import Layout from "../pages/Layout.vue";
import Login from "../pages/Login.vue";
import NotFound from "../pages/NoutFound.vue";

const router = createRouter({
    history: createWebHashHistory(),
    routes: [
        {
            path: "/",
            component: Layout,
            name: "home",
            meta: {}
        },
        {
            path: "/login",
            component: Login,
            name: "login",
            meta: {}
        },
        {
            path: "/404",
            component: NotFound,
            name: "NotFound",
            meta: {}
        }
    ]
});

export default router;
