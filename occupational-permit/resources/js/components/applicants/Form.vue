<script setup lang="ts">
import { reactive, watch, ref, onMounted } from "vue";
import useApplicants from "../../composables/applicants";
import VueMultiselect from "vue-multiselect";
//import useRoles from "../../composables/roles";


const { errors, is_success, storeApplicant, updateApplicant } = useApplicants();
const emit = defineEmits(["reloadApplicants", "input"]);
const props = defineProps({
    applicant: {
        type: Object,
        default: null,
    },
    value: {
        type: Boolean,
        default: false,
    },
});
watch(
    () => props.applicant,
    (value) => {
        form.id = value.id;
        form.LastName = value.LastName;
        form.FirstName = value.FirstName;
        form.MiddleName = value.MiddleName;
        form.ExtensionName = value.ExtensionName;
        form.Age = value.Age;
        form.CivilStatus = value.CivilStatus;
        form.Photo = value.Photo;           
    }
);
const initialState = {
    id: null,
    LastName: null,
    FirstName: null,
    MiddleName: null,
    middle_name: null,
    ExtensionName: null,
    Age: null,
    CivilStatus: null,
    Photo: null,
};
const form = reactive({ ...initialState });



const preloader = ref(false);
const show_form_modal = ref(false);
watch(
    () => props.value,
    (value) => {
        show_form_modal.value = value;
    }
);
const saveApplicant = async () => {
    preloader.value = true;
    if (props.applicant && props.applicant.id) {
        await updateApplicant({ ...form });
    } else {
        await storeApplicant({ ...form });
    }
    if (is_success.value) {
        emit("reloadApplicants");
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
                <span class="text-h5">New Applicant</span>
            </v-card-title>
            <v-card-text class="mx-5">
                <v-row>
                    <v-col cols="6">
                        <v-row>
                            <v-text-field
                                label="First Name*"
                                v-model="form.FirstName"
                                :error-messages="
                                   errors['FirstName']
                                        ? errors['FirstName']
                                        : []
                                "
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                                label="Last Name*"
                                v-model="form.LastName"
                                :error-messages="
                                    errors['LastName']
                                        ? errors['LastName']
                                        : []
                                "
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                                label="Middle Name"
                                v-model="form.MiddleName"
                                class="mr-1"
                                :error-messages="
                                    errors['MiddleName']
                                        ? errors['MiddleName']
                                        : []
                                "
                            ></v-text-field>
                            <v-text-field
                                label="Extension Name"
                                v-model="form.ExtensionName"
                                :error-messages="
                                    errors['ExtensionName']
                                        ? errors['ExtensionName']
                                        : []
                                "
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-textarea
                                label="Age"
                                v-model="form.Age"
                                rows="3"
                                :error-messages="
                                    errors['Age'] ? errors['Age'] : []
                                "
                            ></v-textarea>
                        </v-row>
                        <v-row>
                            <v-text-field
                                label="Civil Status"
                                v-model="form.CivilStatus"
                                class="mr-1"
                                :error-messages="
                                    errors['CivilStatus']
                                        ? errors['CivilStatus']
                                        : []
                                "
                            ></v-text-field>
                            <v-file-input v-model="form.Photo" accept="image/*" label="add Photo*" required></v-file-input>
                            
                        </v-row>
                    </v-col>
                    <v-col cols="6">
                        
                      <!-- Save and Cancel Button   -->
                        <v-row class="mt-3 mb-5">
                            <v-btn class="ma-2" color="blue-darken-1" @click="saveApplicant">
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


    <!-- Persistent overlay -->
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