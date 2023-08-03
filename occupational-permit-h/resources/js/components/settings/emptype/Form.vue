<script setup lang="ts">
import { reactive, defineEmits, defineProps, watch, ref } from "vue";
import useTypes from "../../../composables/types";
const { errors, is_success, storeType, updateType } = useTypes();

const emit = defineEmits(["reloadTypes", "input"]);
const props = defineProps({
    type: {
        type: Object,
        default: null,
    },
    value: {
        type: Boolean,
        default: false,
    },
});
watch(
    () => props.type,
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

const saveType = async () => {
    if (props.type && props.type.id) {
        await updateType({ ...form });
    } else {
        await storeType({ ...form });
    }
    if (is_success.value) {
        emit("reloadTypes");
        emit("input", false);
    }
};

const closeDialog = (value) => {
    emit("input", value);
};
</script>

<template>
    <v-dialog v-model="show_form_modal" width="500" scrollable persistent>
        <v-card>
            <v-card-title>
                <span class="text-h5">Type</span>
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="12">
                        <v-text-field
                            label="Type*"
                            v-model="form.name"
                            :error-messages="
                                errors['name'] ? errors['name'] : []
                            "
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
                <v-btn class="ma-2" color="blue-darken-1" @click="saveType">
                    Save
                    <v-icon end icon="mdi-checkbox-marked-circle"></v-icon>
                </v-btn>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>
