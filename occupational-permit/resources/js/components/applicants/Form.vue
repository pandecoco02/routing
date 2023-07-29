<script setup lang="ts">
import { reactive, watch, ref, onMounted } from "vue";
import useApplicants from "../../composables/applicants";
import usePermits from "../../composables/permits";
import useSignatory from "../../composables/signatories";
import VueMultiselect from "vue-multiselect";

const {permiterrors, is_permitsuccess, storePermit,updatePermit} = usePermits();
const { errors, is_success, storeApplicant, updateApplicant } = useApplicants();
const {signatories, getSignatories} = useSignatory();

const emit = defineEmits(["reloadApplicants", "input", "reloadPermits"]);
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
        form.CommunityTaxNumber = value.CommunityTaxNumber;
        form.CommunityTaxFee = value.CommunityTaxFee;
        form.CommunityTaxDatePaid = value.CommunityTaxDatePaid;
        form.MayorsPermitNumber = value.MayorsPermitNumber;
        form.MayorsPermitFee = value.MayorsPermitFee;
        form.MayorsPermitDatePaid = value.MayorsPermitDatePaid;
        form.HealthCardNumber = value.HealthCardNumber;
        form.PoliceClearanceNo = value.PoliceClearanceNo;
        form.PoliceClearanceExpiryDate = value.PoliceClearanceExpiryDate;
        form.DateIssued = value.DateIssued;
        form.DateHired = value.DateHired;
        form.selected_signatories = value.signatories;
       // form.SignatoryID = value.SignatoryID;
        form.EmploymentTypeID = value.EmploymentTypeID;
        form.Status = value.Status;
    }
);
const initialState = {
    id: null,
    LastName: null,
    FirstName: null,
    MiddleName: null, 
    ExtensionName: null,
    Age: null,
    CivilStatus: null,
    Photo: null,
    CommunityTaxNumber: null,
    CommunityTaxFee: null,
    CommunityTaxDatePaid: null,
    MayorsPermitNumber: null,
    MayorsPermitFee: null,
    MayorsPermitDatePaid: null,
    HealthCardNumber: null,
    PoliceClearanceNo: null,
    PoliceClearanceExpiryDate: null,
    DateIssued: null,
    DateHired: null,
    //SignatoryID: null,
    selected_signatories:[],
    applicant_signatory:[],
    EmploymentTypeID: null,
    Status: null,
};
const form = reactive({ ...initialState });

onMounted(()=>{
    getSignatories();
})
const preloader = ref(false);
const show_form_modal = ref(false);

watch(
    () => props.value,
    (value) => {
        show_form_modal.value = value;
    }
);
watch(
    () => form.selected_signatories,
    (value) => {
        if(value) {
            form.applicant_signatory = value.map((x)=>x.id)
        }
    }
);
const saveApplicant = async () => {
    preloader.value = true;
    if (props.applicant && props.applicant.id  ) {
        await updateApplicant({ ...form });
       
    } else {
        await storeApplicant({ ...form });
       
    }
    if (is_success.value || is_permitsuccess.value) {
        emit("reloadApplicants");
        emit("reloadPermits");
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
    <v-dialog v-model="show_form_modal" width="60%" persistent>
        
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
                            <v-text-field
                                type="number"
                                label="Age"
                                v-model="form.Age"
                                class="mr-1"
                                :error-messages="
                                    errors['Age'] ? errors['Age'] : []
                                "
                            ></v-text-field>
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
                        </v-row> 
                        <v-row>
                             <v-file-input v-model="form.Photo" accept="image/*" label="add Photo*" required></v-file-input>
                        </v-row>
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
                   
                 <v-col cols="6">
                    <div class="custom-bg custom-bg2 mt-7 pt-5">     
                        <v-row>
                            <v-text-field
                                label="CommunityTaxNumber*"  
                                v-model="form.CommunityTaxNumber"
                                :permiterror-messages="
                                    permiterrors['CommunityTaxNumber']
                                        ? permiterrors['CommunityTaxNumber']
                                        : []
                                "                              
                            ></v-text-field>
                        </v-row>

                        <v-row>
                            <v-text-field
                                label="CommunityTaxFee*" 
                                v-model="form.CommunityTaxFee"
                                :permiterror-messages="
                                    permiterrors['CommunityTaxFee']
                                        ? permiterrors['CommunityTaxFee']
                                        : []
                                "                                 
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                            type="date"
                                label="CommunityTaxDatePaid*" 
                                v-model="form.CommunityTaxDatePaid"
                                :permiterror-messages="
                                    permiterrors['CommunityTaxDatePaid']
                                        ? permiterrors['CommunityTaxDatePaid']
                                        : []
                                "                                 
                            ></v-text-field>
                        </v-row>
                       
                        <v-row>
                            <v-text-field
                            
                                label="MayorsPermitNumber*"
                                v-model="form.MayorsPermitNumber"
                                :permiterror-messages="
                                    permiterrors['MayorsPermitNumber']
                                        ? permiterrors['MayorsPermitNumber']
                                        : []
                                "                                  
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                                type="number"
                                label="MayorsPermitFee*"
                                v-model="form.MayorsPermitFee"
                                :permiterror-messages="
                                    permiterrors['MayorsPermitFee']
                                        ? permiterrors['MayorsPermitFee']
                                        : []
                                "                                  
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                            type="date"
                                label="MayorsPermitDatePaid*"
                                v-model="form.MayorsPermitDatePaid"
                                :permiterror-messages="
                                    permiterrors['MayorsPermitDatePaid']
                                        ? permiterrors['MayorsPermitDatePaid']
                                        : []
                                "                                    
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                                label="HealthCardNumber*"
                                v-model="form.HealthCardNumber"
                                :permiterror-messages="
                                    permiterrors['HealthCardNumber']
                                        ? permiterrors['HealthCardNumber']
                                        : []
                                "                                  
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                                label="PoliceClearanceNo*"
                                v-model="form.PoliceClearanceNo"
                                :permiterror-messages="
                                    permiterrors['PoliceClearanceNo']
                                        ? permiterrors['PoliceClearanceNo']
                                        : []
                                "                                    
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                               type="date"
                                label="PoliceClearanceExpiryDate*"
                                v-model="form.PoliceClearanceExpiryDate"
                                :permiterror-messages="
                                    permiterrors['PoliceClearanceExpiryDate']
                                        ? permiterrors['PoliceClearanceExpiryDate']
                                        : []
                                "                               
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <!-- <v-text-field
                                label="Signatory*" 
                                v-model="form.SignatoryID"
                                :permiterror-messages="
                                    permiterrors['SignatoryID']
                                        ? permiterrors['SignatoryID']
                                        : []
                                "                                 
                            ></v-text-field> -->
                                <v-label>Signatory:</v-label>
                                <vue-multiselect
                                v-model="form.selected_signatories"
                                :options="signatories"
                                :multiple="false"
                                :close-on-select="true"
                                :clear-on-select="false"
                                :preserve-search="true"
                                placeholder="Select signatory"
                                label="name"
                                track-by="name"
                                class="mb-10 signatories"
                                select-label=""
                                deselect-label=""
                            >
                            </vue-multiselect>
                            <span class="text-danger">{{
                                errors["selected_signatories"]
                                    ? errors["selected_signatories"][0]
                                    : ""
                            }}</span>
                            <v-spacer></v-spacer>
                        </v-row> 
                        <v-row>
                            <v-text-field
                                label="Employment Type*"
                                v-model="form.EmploymentTypeID"
                                :permiterror-messages="
                                    permiterrors['EmploymentTypeID']
                                        ? permiterrors['EmploymentTypeID']
                                        : []
                                "                                  
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                                label="Status*" 
                                v-model="form.Status"
                                :permiterror-messages="
                                    permiterrors['Status']
                                        ? permiterrors['Status']
                                        : []
                                "                                 
                            ></v-text-field>
                        </v-row>
                    </div>
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