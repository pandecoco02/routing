<script setup lang="ts">
import { reactive, defineEmits, defineProps, watch, ref } from "vue";
import useRoles from "../../../composables/roles";
const { errors, storeRole, updateRole } = useRoles();

const emit = defineEmits(["reloadRoles", "input"]);
const props = defineProps({
    role: {
        type: Object,
        default: null,
    },
    value: {
        type: Boolean,
        default: false,
    },
});
watch(
    () => props.role,
    (value) => {
        form.id = value.id;
        form.name = value.name;
        form.description = value.description;
    }
);

const show_form_modal = ref(false);
watch(
    () => props.value,
    (value) => {
        show_form_modal.value = value;
    }
);

const form = reactive({
    id: null,
    name: null,
    description: "",
});

const saveRole = async () => {
    if (props.role && props.role.id) {
        await updateRole({ ...form });
    } else {
        await storeRole({ ...form });
    }
    emit("reloadRoles");
    emit("input", false);
};

const closeDialog = (value) => {
    emit("input", value);
};
</script>

<template>
    <v-dialog v-model="show_form_modal" width="500" scrollable persistent>
        <v-card>
            <v-card-title>
                <span class="text-h5">Role</span>
            </v-card-title>
            <v-card-text>
                <form class="space-y-6" @submit.prevent="saveRole">
                    <v-row>
                        <v-col cols="12">
                            <v-text-field
                                label="Role*"
                                v-model="form.name"
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                label="Description"
                                v-model="form.description"
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-spacer></v-spacer>

                    <v-btn
                        class="ma-2"
                        color="blue-grey-lighten-1"
                        @click="closeDialog(false)"
                    >
                        <v-icon start icon="mdi-minus-circle"></v-icon>
                        Cancel
                    </v-btn>
                    <v-btn class="ma-2" color="blue-darken-1" type="submit">
                        Save
                        <v-icon end icon="mdi-checkbox-marked-circle"></v-icon>
                    </v-btn>
                </form>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>