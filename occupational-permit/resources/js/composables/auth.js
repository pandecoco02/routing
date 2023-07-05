import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { useStore } from "vuex";

export default function useAuth() {
    const user = ref(null);
    const is_loading = ref(false); 

    const store = useStore();

    const errors = ref("");
    const has_role = ref(false);
    const router = useRouter();

    const logout = async () => {
        await axios.post("/logout")
        .then(() => {
            store.dispatch('auth/logout');

            location.reload();
            is_loading.value = false;
        }).catch((error) => {
            console.log(error);
        });
    };

    const login = async (data) => {
        is_loading.value = true;
        await axios.post("/login", data)
        .then((response) => {
            user.value = response.data.user;
            localStorage.setItem('token', response.data.access_token);
            localStorage.setItem('user', JSON.stringify(response.data.user));
            if(!user.value.is_new){
                store.dispatch('auth/login');
            }
        })
        .catch((error) => {
            errors.value = error.response.data.message;
            console.log(error);
        })
        .finally(() => {
            is_loading.value = false;
        });
    }

    const storePassword = async (data) => {
        is_loading.value = true;
        await axios.post("/setpassword", data)
        .then(() => {
            store.dispatch('auth/login');
            location.reload();
        })
        .catch((error) => {
            errors.value = error.response.data.message;
            console.log(error);
        })
        .finally(() => {
            is_loading.value = false;
        });
    }

    return {
        errors,
        is_loading,
        user,
        logout,
        login,
        storePassword
    };
}
