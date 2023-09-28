import {createRouter, createWebHashHistory} from "vue-router";
import Layout from "../pages/Layout.vue";
import Login from "../pages/login.vue";
import NotFound from "../pages/notFound.vue";

const router = createRouter({
    history: createWebHashHistory(),
    routes: [
        {
            path: "/",
            component: Layout,
            name: "home",
            meta: {
                title: "仪表盘"
            }
        },
        {
            path: "/login",
            component: Login,
            name: "login",
            meta: {
                title: "登录"
            }
        },
        {
            path: "/404",
            component: NotFound,
            name: "NotFound",
            meta: {
                title: "404"
            }
        }
    ]
});

router.afterEach((to) => {
    const title = to.meta?.title || '';

    document.title = title ? title + " | " + document.title : document.title;
});

export default router;
