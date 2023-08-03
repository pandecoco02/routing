<script setup lang="ts">
import { ref, reactive, watch } from "vue";
import useAuth from "../../composables/auth.js";

const { is_loading, storePassword, errors } = useAuth();

const props = defineProps({
    userId: {
        type: Number,
        default: null,
    },
});

watch(() => props.userId,
    (value) => {
        if(value){
            form.user_id = value;
        }
    }
);

const form = reactive({
    user_id: null,
    password: null,
    password_confirmation: null,
});

const showPassword = ref(false);
const showConfirmPassword = ref(false);

const toggleShow = () => {
    showPassword.value = !showPassword.value;
};

const toggleShowConfirm = () => {
    showConfirmPassword.value = !showConfirmPassword.value;
}

const savePassword = async () => {
    await storePassword({ ...form });
};
</script>

<template>
    <v-alert
        v-if="errors"
        type="error"
        :title="errors"
        transition="slide-y-transition"
        icon="mdi-alert-circle-outline"
    ></v-alert>
    <form class="sign-up-form" @submit.prevent="savePassword">
        <div style="max-width: 200px" class="mb-4">
            <img
                src="../../../../public/images/cho.png"
                alt="CHO Seal"
                class="img-fluid"
            />
        </div>
        <h2 class="title">Set Password</h2>
        <div class="input-field">
            <v-icon icon="mdi-lock" size="30" class="mt-3"></v-icon>
            <input
                v-if="showPassword"
                type="text"
                v-model="form.password"
                placeholder="Password"
                required
            />
            <input
                v-else
                type="password"
                v-model="form.password"
                placeholder="Password"
                required
            />
            <div class="control">
                <v-icon
                    @click="toggleShow"
                    :icon="
                        showPassword ? 'mdi-eye-off-outline' : 'mdi-eye-outline'
                    "
                ></v-icon>
            </div>
        </div>
        <div class="input-field">
            <v-icon icon="mdi-lock" size="30" class="mt-3"></v-icon>
            <input
                v-if="showConfirmPassword"
                type="text"
                v-model="form.password_confirmation"
                placeholder="Password"
                required
            />
            <input
                v-else
                type="password"
                v-model="form.password_confirmation"
                placeholder="Password"
                required
            />
            <div class="control">
                <v-icon
                    @click="toggleShowConfirm"
                    :icon="
                        showConfirmPassword ? 'mdi-eye-off-outline' : 'mdi-eye-outline'
                    "
                ></v-icon>
            </div>
        </div>
        <v-row>
            <v-col cols="12">
                <v-btn class="btn solid" type="submit" :loading="is_loading" block size="x-large">
                    Submit
                </v-btn>
            </v-col>
        </v-row>
    </form>
</template>

