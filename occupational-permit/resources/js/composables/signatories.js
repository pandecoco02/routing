import { ref } from "vue";
import axios from "axios";
import Swal from "sweetalert2";

export default function useSignatories() {
    const signatory = ref(null);
    const signatories = ref([]);
    const is_success = ref(false);
    const is_loading = ref(false);
    const pagination = ref({});
    const query = ref({
        search: null,
        page: 1,
    });

    const errors = ref({});

    const getSignatories = async (params = {}, type = "") => {
        is_loading.value = true;

        let query_str = { ...query.value, ...params };
        let url = type == "client" ? "/form/signatories" : "/signatories";
        await axios
            .get(`${url}?page=${query.value.page}`, { params: query_str })
            .then((response) => {
                signatories.value = response.data.data;
                pagination.value = response.data.meta;
                is_loading.value = false;
            });
    };

    const getSignatory = async (id) => {
        let response = await axios.get(`/signatories/${id}`);
        signatory.value = response.data;
        is_loading.value = false;
    };

    const storeSignatory = async (data) => {
        is_loading.value = true;
        errors.value = "";
        try {
            await axios.post("/signatories", data).then((response) => {
                if (response.data.error) {
                    Swal.fire({
                        title: "error",
                        icon: "error",
                        text: response.data.message,
                    });

                    errors.value = response.data.message;
                } else {
                    Swal.fire({
                        title: "Success",
                        icon: "success",
                        text: response.data.message,
                    });
                    errors.value = {};
                    is_loading.value = false;
                    is_success.value = true;
                }
            });
        } catch (e) {
            console.log(e);
            if (e.response.status === 422) {
                errors.value = e.response.data;
                is_success.value = false;
            }
        }
    };

    const updateSignatory = async (updated_signatory) => {
        errors.value = "";
        try {
            is_loading.value = true;
            signatory.value = updated_signatory;
            await axios
                .patch(`/signatories/${signatory.value.id}`, signatory.value)
                .then((response) => {
                    Swal.fire({
                        title: "Success",
                        icon: "success",
                        text: response.data.message,
                    });
                    errors.value = {};
                    is_loading.value = false;
                    is_success.value = true;
                });
        } catch (e) {
            if (e.response.status === 422) {
                errors.value = e.response.data;
                is_success.value = false;
            }
        }
    };

    const destroySignatory = async (id) => {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.value) {
                axios
                    .delete(`/signatories/${id}`)
                    .then((response) => {
                        getSignatories(query.value);
                        Swal.fire("Deleted!", response.data.message, "success");
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                        });
                    });
            }
        });
    };

    return {
        errors,
        pagination,
        is_loading,
        query,
        is_success,
        signatory,
        signatories,
        getSignatories,
        getSignatory,
        storeSignatory,
        updateSignatory,
        destroySignatory,
    };
}
