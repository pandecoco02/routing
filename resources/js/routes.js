import { createWebHistory, createRouter } from 'vue-router'
import store from '@/store'

/* Guest Component */
const Login = () => import('@/views/auth/Login.vue')
/* Guest Component */

/* Layouts */
const Authenticated = () => import('@/components/layouts/App.vue')
const Guest = () => import('@/components/layouts/Guest.vue')
/* Layouts */

/* Authenticated Component */
const Dashboard = () => import('@/views/Dashboard.vue')
const Roles = () => import("@/views/settings/libraries/Roles.vue");
/* Authenticated Component */


const routes = [
    {
        name: "guest",
        path: "/",
        component: Guest,
        meta: {
            middleware: "guest",
            title: `Guest`,
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
        path: "/home",
        component: Authenticated,
        meta: {
            middleware: "auth"
        },
        children: [
            {
                name: "dashboard",
                path: '/dashboard',
                component: Dashboard,
                meta: {
                    title: `Dashboard`
                }
            },
            {
                name: "roles",
                path: '/roles',
                component: Roles,
                name: 'roles.index',
                meta: {
                    title: `Roles`
                }
            },
        ]
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes, // short for `routes: routes`
})

router.beforeEach((to, from, next) => {
    document.title = to.meta.title
    if (to.meta.middleware == "guest") {
        if (store.state.auth.authenticated) {
            next({ name: "dashboard" })
        }
        next()
    } else {
        if (store.state.auth.authenticated) {
            next()
        } else {
            next({ name: "guest" })
        }
    }
})

export default router