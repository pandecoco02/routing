<script setup lang="ts">
import { RouterView } from "vue-router";
import { ref, onMounted } from "vue";
import Sidebar from "./partials/Sidebar.vue";
import Header from "./partials/Header.vue";

const drawer = ref(undefined || true);
const innerW = window.innerWidth;
const clipped = ref(true);

onMounted(() => {
    if (innerW < 950) {
        drawer.value = !drawer.value;
    }
});
</script>

<template>
    <v-app>
        <!-- ---------------------------------------------- -->
        <!---Sidebar -->
        <!-- ---------------------------------------------- -->
        <sidebar :drawer="drawer" />
        <!-- ---------------------------------------------- -->
        <!---Header -->
        <!-- ---------------------------------------------- -->
        <v-app-bar app :clipped-left="clipped" :elevation="0">
            <v-app-bar-nav-icon
                @click.stop="drawer = !drawer"
            ></v-app-bar-nav-icon>
            <v-spacer />
            <!-- ---------------------------------------------- -->
            <!-- User Profile -->
            <!-- ---------------------------------------------- -->
            <header />
        </v-app-bar>

        <!-- ---------------------------------------------- -->
        <!---Page Wrapper -->
        <!-- ---------------------------------------------- -->
        <v-main>
            <v-container fluid>
                <RouterView />
            </v-container>
        </v-main>
    </v-app>
</template>