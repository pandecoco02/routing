<script setup lang="ts">
import "../../../../public/css/login.css";
import { ref, reactive } from "vue";
import useAuth from "../../composables/auth.js";
import SetPassword from "./SetPassword.vue"

const { is_loading, errors, user, login } = useAuth();

const isSignUpMode = ref(false);
const showPassword = ref(false);
const user_id = ref("");

const form = reactive({ 
    email: null,
    password: null,
});
    
const signIn = async () => {
    await login({ ...form })
    .then(() => {
        if(user){
            isSignUpMode.value = user.value.is_new;
            user_id.value = user.value.id;
        }
    });
};

const setSignUpMode = () => {
    isSignUpMode.value = true;
};

const setSignInMode = () => {
    isSignUpMode.value = false;
};

const toggleShow = () => {
    showPassword.value = !showPassword.value;
}
</script>

<template>
    <div>
        <div class="container1" :class="{ 'sign-up-mode': isSignUpMode }">
            <div class="forms-container">
                <div class="signin-signup">
                    <v-alert
                        v-if="errors"
                        type="error"
                        :title="errors"
                        transition="slide-y-transition"
                        icon="mdi-alert-circle-outline"
                    ></v-alert>
                    <form @submit.prevent="signIn" class="sign-in-form">
                        <div style="max-width: 200px" class="mb-4">
                            <img
                                src="../../../../public/images/cho.png"
                                alt="CHO Seal"
                                class="img-fluid"
                            />
                        </div>
                        <h2 class="title">Sign In</h2>
                        <div class="input-field">
                            <v-icon icon="mdi-account" size="30" class="mt-3"></v-icon>
                            <input
                                type="text"
                                placeholder="Email"
                                prepend-icon="mdi-account"
                                v-model="form.email"
                                label="Email"
                                required
                            />
                        </div>
                        <div class="input-field">
                            <v-icon icon="mdi-lock" size="30" class="mt-3"></v-icon>
                            <input v-if="showPassword" type="text" v-model="form.password" placeholder="Password" required/>
                            <input v-else type="password" v-model="form.password" placeholder="Password" required>
                            <div class="control">
                                <v-icon @click="toggleShow" :icon="showPassword ? 'mdi-eye-off-outline' : 'mdi-eye-outline'"></v-icon>
                            </div>
                        </div>
                        <v-row>
                            <v-col cols="12">
                                <v-btn
                                    class="btn solid"
                                    type="submit"
                                    :loading="is_loading"
                                    block size="x-large"
                                >
                                    LOGIN
                                </v-btn>
                            </v-col>
                        </v-row>
                    </form>

                    <set-password :user-id="user_id"/>
                </div>
            </div>

            <div class="panels-container">
                <div class="panel left-panel">
                    <div class="content">
                        <h3>New here ?</h3>
                        <p>
                            Lorem ipsum, dolor sit amet consectetur adipisicing
                            elit. Debitis, ex ratione. Aliquid!
                        </p>
                        <button
                            class="btn transparent"
                            id="sign-up-btn"
                            @click="setSignUpMode"
                        >
                            Set Password
                        </button>
                    </div>
                </div>
                <div class="panel right-panel">
                    <div class="content">
                        <h3>One of us ?</h3>
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Nostrum laboriosam ad deleniti.
                        </p>
                        <button
                            class="btn transparent"
                            id="sign-in-btn"
                            @click="setSignInMode"
                        >
                            Sign in
                        </button>
                    </div>
                    <img src="img/register.svg" class="image" alt="" />
                </div>
            </div>
        </div>
    </div>
</template>