<script setup>
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { useStore } from "vuex";

const email = ref("");
const password = ref("");
const router = useRouter();
const isLoading = ref(false);
const errorMessage = ref("");

const store = useStore();

const submit = async () => {
    await axios.get("/sanctum/csrf-cookie").then(() => {
        isLoading.value = true;
        axios
            .post("/login", {
                email: email.value,
                password: password.value,
            })
            .then((response) => {
                store.commit("auth/SET_AUTHENTICATED", true);
                store.commit("auth/SET_USER", response.data.user);

                router.push({ name: "dashboard" });
            })
            .catch((error) => {
                if(error.response.status == 401){
                    errorMessage.value = error.response.data.message
                }
                console.log(error);
            })
            .finally(() => {
                isLoading.value = false;
            });
    });
};
</script>

<template>
    <v-container fluid fill-height>
        <v-layout class="align-center justify-center">
            <v-flex xs12 sm8 md4 class="card">
                <v-alert
                    v-if="errorMessage"
                    type="error"
                    :title="errorMessage"
                ></v-alert>
                <v-card class="elevation-12">
                    <v-toolbar dark>
                        <v-toolbar-title></v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>
                        <v-form @submit.prevent="submit">
                            <v-text-field
                                prepend-icon="mdi-account"
                                v-model="email"
                                label="Email"
                                type="text"
                            ></v-text-field>
                            <v-text-field
                                prepend-icon="mdi-lock"
                                v-model="password"
                                label="Password"
                                type="password"
                            ></v-text-field>
                            <br />
                            <v-btn
                                :loading="isLoading"
                                color="blue-darken-1"
                                type="submit"
                                class="mr-0 ml-auto"
                                >LOGIN</v-btn
                            >
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<style>
.card{
    width:35%;
    margin-top: 50px;
}
</style>