<script setup lang="ts">
import { ref, onMounted } from "vue";
import ApplicantForm from "../../components/applicants/Form.vue";
import PermitForm from "../../components/applicants/Permit.vue";
import usePermits from "../../composables/permits.js";
import useApplicants from "../../composables/applicants.js";
import { VDataTable } from "vuetify/labs/VDataTable";

const { applicants, pagination, query, is_loading, getApplicants, destroyApplicant } =   useApplicants();
const {getPermits,destroyPermit} = usePermits();

const applicant = ref({});
const show_form_modal = ref(false);
const show_permitform_modal = ref(false);
const headers = [
    { title: "ID", key: "id" },
    { title: "Name", key: "name" },
    { title: "Age", key: "age" },
    { title: "", key: "actions" },
];
onMounted(() => {
    reloadApplicants();
});

const reloadApplicants = async () => {
    await getApplicants();
    applicant.value = {};
};

const updateApplicant = async (row) => {
    applicant.value = row;
    show_form_modal.value = true;
    console.log(applicant.value);
};
const deleteApplicant = async (id) => {
    await destroyApplicant(id);
};

const showApplicantForm = async (is_show) => {
    applicant.value = {};
    show_form_modal.value = is_show;
};

const addPermit = async (id) => {
    applicant.value = id;
    show_permitform_modal.value = true;
    console.log(applicant.value);
};
const showPermitForm = async (is_show) => {
    applicant.value = {};
    show_permitform_modal.value = is_show;

};
</script>
<template>

    <div style="text-align: end">
        <v-btn
            class="ma-2"
            color="blue-darken-1"
            @click="showApplicantForm(true)"
        >
            <v-icon start icon="mdi-plus"></v-icon>
           Applicant
        </v-btn>
    </div>
    <v-card>
         <div
            class="overflow-hidden overflow-x-auto min-w-full align-middle sm:rounded-md"
        >
            <v-card-title>List of Applicants </v-card-title>
            <v-divider class="mx-4 mb-1"></v-divider>
            <v-card-title>
                <v-text-field
                    v-model="query.search"
                    append-icon="mdi-magnify"
                    label="Search"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
           <v-data-table
                :headers="headers"
                :items="applicants"
                :search="query.search"
                class="elevation-1"
                :loading="is_loading"
                loading-text="Loading... Please wait"
            >
                <template v-slot:item.name="{ item }">
                    {{  item.raw.LastName+
                        ", " +                        
                         item.raw.FirstName+
                        " " +
                        (item.raw.MiddleName ? item.raw.MiddleName : " ") +
                        ". " 
                    }}
                </template>
                <template v-slot:item.age="{ item }">
                    {{ 
                        (item.raw.Age ? item.raw.Age : "") 
                    }}
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-menu open-on-hover>
                        <template v-slot:activator="{ props }">
                            <v-btn color="#BDBDBD" v-bind="props" size="small">
                                Action
                                <v-icon end icon="mdi-dots-vertical"></v-icon>
                            </v-btn>
                        </template>
                        <v-list max-width="200px" class="p-2">
                            <div width="100%">
                                <v-btn
                                width="100%"
                                color="blue"
                                @click="addPermit(item.raw)"
                                size="small"
                            >
                                Permit
                                <v-icon end icon="mdi-sheet"></v-icon>
                                </v-btn>
                                <v-btn
                                    width="100%"
                                    color="green"
                                    @click="updateApplicant(item.raw)"
                                    size="small"
                                >
                                    Edit
                                    <v-icon end icon="mdi-pencil"></v-icon>
                                </v-btn>
                                <v-btn
                                    width="100%"
                                    class="mt-2"
                                    color="red"
                                    @click="deleteApplicant(item.raw.id)"
                                    size="small"
                                >
                                    Delete
                                    <v-icon end icon="mdi-delete"></v-icon>
                                </v-btn>
                            </div>
                        </v-list>
                    </v-menu> </template
                ><template v-slot:bottom>
                    <div class="m-2">
                        <span style="color: gray" v-if="pagination">
                            Showing {{ pagination.from }} to
                            {{ pagination.to }} out of
                            <b>{{ pagination.total }} records</b>
                        </span>
                        <div class="text-center">
                            <v-pagination
                                v-model="query.page"
                                :length="pagination.last_page"
                                circle
                                @click="getApplicants"
                            ></v-pagination>
                        </div>
                    </div>
                </template>
            </v-data-table>
        </div>
    </v-card> 
    <applicant-form
        :value="show_form_modal"
        :applicant="applicant"
        @reloadApplicants="reloadApplicants"
        @input="showApplicantForm" 
    />
    <permit-form
        :value="show_permitform_modal"
        :applicant="applicant"
        @reloadApplicants="reloadApplicants"
        @input="showPermitForm" 
    /> 
</template>
