import { createWebHistory, createRouter } from "vue-router";
import store from "@/store";

/* Guest Component */
const Login = () => import("@/views/auth/Login.vue");
/* Guest Component */

/* Layouts */
const Authenticated = () => import("@/components/layouts/App.vue");
const Guest = () => import("@/components/layouts/Guest.vue");
/* Layouts */

/* Authenticated Component */
const Dashboard = () => import("@/views/Dashboard.vue");
const Roles = () => import("@/views/settings/libraries/Roles.vue");
const Users = () => import("@/views/user/Index.vue");
const Applicants = () => import("@/views/Employee/Index.vue");
const Type = () => import ("@/views/settings/libraries/Types.vue");
// const Permits = () => import
/* Authenticated Component */

const routes = [
    {
        name: "guest",
        path: "/",
        component: Guest,
        meta: {
            middleware: "guest",
            title: `Occupational Permit`,
        },
    },
    {
        name: "login",
        path: "/login",
        component: Login,
        meta: {
            middleware: "guest",
            title: `Login`,
        },
    },
    {
        name: "home",
        path: "/home",
        component: Authenticated,
        meta: {
            middleware: "auth",
            title: `Home | Occupational Permit`,
        },
        children: [
            {
                name: "dashboard",
                path: "/dashboard",
                component: Dashboard,
                meta: {
                    title: `Dashboard`,
                },
            },
            {
                name: "roles",
                path: "/roles",
                component: Roles,
                name: "roles.index",
                meta: {
                    title: `Roles`,
                },
            },
            {
                name: "users",
                path: "/users",
                component: Users,
                name: "users.index",
                meta: {
                    title: `Users`,
                },
            },
            // Applicant view
            {
                name: "applicants",
                path: "/applicants",
                component: Applicants,               
                meta: {
                    title: `Applicant`,
                },
            },
            {
                name: "types",
                path: "/types",
                component: Type,    
                name: "types.index",           
                meta: {
                    title: `Employment Types`,
                },
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes, // short for `routes: routes`
});

router.beforeEach((to, from, next) => {
    document.title = to.meta.title;
    if (to.meta.middleware == "guest") {
        if (store.state.auth.authenticated) {
            next({ name: "dashboard" });
        }
        next();
    } else {
        if (store.state.auth.authenticated) {
            next();
        } else {
            next({ name: "login" });
        }
    }
});

export default router;
