<script setup lang="ts">
import { ref, watch } from "vue";
import { RouterLink } from "vue-router";
import axios from "axios";

const props = defineProps({
    drawer: {
      type: Boolean,
      required: true
    }
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
    { title: "Role", icon: "mdi-form-dropdown", route: "/roles" },
];

const Logout = async () => {
    await axios
        .post("/logout")
        .then(() => {
            localStorage.clear();
            location.reload();
        })
        .catch((error) => {
            console.log(error);
        });
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
              <h5> 
                <v-icon small>mdi-note-text-outline</v-icon> 
                Document Tracker
              </h5>
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
        </v-list>

        <v-list-item-group class="sidebar-bottom">
          <v-list-item>
            <template v-slot:append>
                <v-icon small @click="Logout">mdi-logout-variant</v-icon>
            </template>
          </v-list-item>
        </v-list-item-group>
    </v-navigation-drawer>
</template>

<style>
.menu-item{
  margin-left: 10px;
  color: white;
}

.menu-item span{
  margin-left: 20px;
}

.project-name {
  padding: 25px;
  text-transform: uppercase;
  border-bottom: 0.5px solid #41545f;
}
.project-name a:link { 
  text-decoration: none; 
  color: #8ed4ff; 
}

.v-navigation-drawer__content {
  background-color: #293742;
}

.v-list-item--active{
  background: #137CBD;
}

.sidebar-bottom {
  background: #222C35;
  position: fixed !important;
  bottom: 0 !important;
  width: 100%;
  color: rgb(136, 134, 134);
}
</style>
