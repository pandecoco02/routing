<script setup lang="ts">
import { reactive, watch, ref, onMounted } from "vue";
import useUsers from "../../composables/users";
import VueMultiselect from "vue-multiselect";
import useRoles from "../../composables/roles";

const { errors, is_success, storeUser, updateUser } = useUsers();
const { roles, getRoles } = useRoles();

const emit = defineEmits(["reloadUsers", "input"]);
const props = defineProps({
    user: {
        type: Object,
        default: null,
    },
    value: {
        type: Boolean,
        default: false,
    },
});

watch(
    () => props.user,
    (value) => {
        form.id = value.id;
        form.email = value.email;
        form.first_name = value.first_name;
        form.last_name = value.last_name;
        form.middle_name = value.middle_name;
        form.extension_name = value.extension_name;
        form.address = value.address;
        form.contact_no = value.contact_no;
        form.position = value.position;
        form.work_place = value.work_place;
        form.selected_roles = value.roles;
    }
);

const initialState = {
    id: null,
    email: null,
    first_name: null,
    last_name: null,
    middle_name: null,
    extension_name: null,
    address: null,
    contact_no: null,
    position: null,
    work_place: null,
    selected_roles: [],
    user_roles: [],
};

const form = reactive({ ...initialState });

onMounted(() => {
    getRoles();
});

const preloader = ref(false);
const show_form_modal = ref(false);
watch(
    () => props.value,
    (value) => {
        show_form_modal.value = value;
    }
);

watch(
    () => form.selected_roles,
    (value) => {
        if (value) {
            form.user_roles = value.map((x) => x.id);
        }
    }
);

const saveUser = async () => {
    preloader.value = true;
    if (props.user && props.user.id) {
        await updateUser({ ...form });
    } else {
        await storeUser({ ...form });
    }
    if (is_success.value) {
        emit("reloadUsers");
        emit("input", false);
        Object.assign(form, initialState);
    }
    preloader.value = false;
};

const closeDialog = (value) => {
    emit("input", value);
};
</script>

<template>
    <v-dialog v-model="show_form_modal" width="80%" persistent>
        <v-card>
            <v-card-title>
                <span class="text-h5">Create User</span>
            </v-card-title>
            <v-card-text class="mx-5">
                <v-row>
                    <v-col cols="6">
                        <v-row>
                            <v-text-field
                                label="First Name*"
                                v-model="form.first_name"
                                :error-messages="
                                    errors['first_name']
                                        ? errors['first_name']
                                        : []
                                "
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                                label="Last Name*"
                                v-model="form.last_name"
                                :error-messages="
                                    errors['last_name']
                                        ? errors['last_name']
                                        : []
                                "
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                                label="Middle Name"
                                v-model="form.middle_name"
                                class="mr-1"
                                :error-messages="
                                    errors['middle_name']
                                        ? errors['middle_name']
                                        : []
                                "
                            ></v-text-field>
                            <v-text-field
                                label="Extension Name"
                                v-model="form.extension_name"
                                :error-messages="
                                    errors['extension_name']
                                        ? errors['extension_name']
                                        : []
                                "
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-textarea
                                label="Address"
                                v-model="form.address"
                                rows="3"
                                :error-messages="
                                    errors['address'] ? errors['address'] : []
                                "
                            ></v-textarea>
                        </v-row>
                        <v-row>
                            <v-text-field
                                label="Contact Number"
                                v-model="form.contact_no"
                                class="mr-1"
                                :error-messages="
                                    errors['contact_no']
                                        ? errors['contact_no']
                                        : []
                                "
                            ></v-text-field>
                            <v-text-field
                                label="Position"
                                v-model="form.position"
                                :error-messages="
                                    errors['position'] ? errors['position'] : []
                                "
                            ></v-text-field>
                        </v-row>
                    </v-col>
                    <v-col cols="6">
                        <div class="custom-title d-flex">
                            <p class="ml-6 pt-1">
                                <span>User Account</span>
                            </p>
                        </div>
                        <div class="custom-bg custom-bg2 mt-7 pt-5">
                            <v-row>
                                <v-text-field
                                    label="Email*"
                                    v-model="form.email"
                                    variant="underlined"
                                    :error-messages="
                                        errors['email'] ? errors['email'] : []
                                    "
                                ></v-text-field>
                            </v-row>
                            <v-row>
                                <v-label>Account Role:</v-label>
                                <vue-multiselect
                                    v-model="form.selected_roles"
                                    :options="roles"
                                    :multiple="true"
                                    :close-on-select="true"
                                    :clear-on-select="false"
                                    :preserve-search="true"
                                    placeholder="Select Role/s"
                                    label="name"
                                    track-by="name"
                                    class="mb-10 roles"
                                    select-label=""
                                    deselect-label=""
                                >
                                </vue-multiselect>
                                <span class="text-danger">{{
                                    errors["selected_roles"]
                                        ? errors["selected_roles"][0]
                                        : ""
                                }}</span>
                                <v-spacer></v-spacer>
                            </v-row>
                        </div>
                        <v-row class="mt-3 mb-5">
                            <v-btn class="ma-2" color="blue-darken-1" @click="saveUser">
                                Save
                                <v-icon end icon="mdi-checkbox-marked-circle"></v-icon>
                            </v-btn>
                            <v-btn
                                class="ma-2"
                                color="blue-grey-lighten-1"
                                @click="closeDialog(false)"
                            >
                                <v-icon start icon="mdi-minus-circle"></v-icon>
                                Cancel
                            </v-btn>
                        </v-row>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-dialog>
    <v-dialog v-model="preloader" hide-overlay persistent width="300">
        <v-card color="primary" dark>
            <v-card-text>
                Processing . . .
                <v-progress-linear
                    indeterminate
                    color="white"
                    class="mb-0"
                ></v-progress-linear>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<style>
.custom-bg {
    padding: 0px 35px;
    padding-top: 15px;
    margin-top: -10px;
    background: #f6f6f6;
}
.custom-bg2{
    background: #f1f8fc !important;
    border: 2px solid #e8f6ff;
}
.custom-title {
    background: #e8f6ff;
    margin-top: 5%;
    margin-bottom: -8%;
    width: 50%;
    text-align: center;
    border-top-right-radius: 50px;
}
.roles .multiselect__tag{
    background: #137cbd;
}
.roles .multiselect__tags {
    background: transparent !important;
}
.roles .multiselect__input {
    background: transparent !important;
}
.roles .multiselect__single {
    background: transparent !important;
}
</style>
