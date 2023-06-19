<script setup lang="ts">
import { ref, watch } from "vue";
import { RouterLink } from "vue-router";
import useAuth from "../../../composables/auth.js";

const { logout } = useAuth();

const props = defineProps({
    drawer: {
        type: Boolean,
        required: true,
    },
});

const clipped = ref(true);
const mini = ref(false);
const drawer = ref(props.drawer);

watch(
    () => props.drawer,
    () => {
        drawer.value = !drawer.value;
    }
);

const items = [
    { title: "Dashboard", icon: "mdi-home", route: "/dashboard" },
    { title: "Accounts", icon: "mdi-account-box", route: "/users" },
];

const libraries = [
    { title: "Role", route: "/roles" },
];

const Logout = async () => {
    await logout();
};
</script>

<template>
    <v-navigation-drawer
        v-model="drawer"
        app
        :mini-variant.sync="mini"
        :clipped="clipped"
    >
        <div class="project-name">
            <RouterLink to="/dashboard">
                <h6>
                    <v-icon small>mdi-note-text-outline</v-icon>
                    Occupational Permit
                </h6>
            </RouterLink>
        </div>

        <v-list dense>
            <v-list-item
                v-for="item in items"
                :key="item.title"
                :to="item.route"
                router
            >
                <span class="menu-item">
                    <v-icon small>{{ item.icon }}</v-icon>
                    <span>{{ item.title }}</span>
                </span>
            </v-list-item>

            <v-list-group>
                <template v-slot:activator="{ props }">
                    <v-list-item
                        v-bind="props"
                        >
                        <span class="menu-item">
                            <v-icon small>mdi-form-dropdown</v-icon>
                            <span>Libraries</span>
                        </span>
                    </v-list-item>
                </template>

                <v-list-item
                    v-for="item in libraries"
                    :key="item.title"
                    :to="item.route"
                    :title="item.title"
                    class="ml-10"
                    router
                ></v-list-item>
            </v-list-group>
            <v-list-item-group class="sidebar-bottom">
                <v-list-item>
                    <template v-slot:append>
                        <v-icon small @click="Logout">mdi-logout-variant</v-icon>
                    </template>
                </v-list-item>
            </v-list-item-group>
        </v-list>
    </v-navigation-drawer>
</template>
