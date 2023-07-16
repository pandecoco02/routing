import { ref, computed } from "vue";
import axios from "axios";
import Swal from "sweetalert2";

export default function useTypes() {
    const type = ref(null);
    const types = ref([]);
    const is_success = ref(false);
    const is_loading = ref(false);
    const pagination = ref({});
    const query = ref({
        search: null,
        page: 1,
    });

    const errors = ref({});

    const getTypes = async (params = {}, type = "") => {
        is_loading.value = true;

        let query_str = { ...query.value, ...params };
        let url = type == "client" ? "/form/types" : "/types";
        await axios
            .get(`${url}?page=${query.value.page}`, { params: query_str })
            .then((response) => {
                types.value = response.data.data;
                pagination.value = response.data.meta;
                is_loading.value = false;
            });
    };

    const getType = async (id) => {
        let response = await axios.get(`/types/${id}`);
        type.value = response.data;
        is_loading.value = false;
    };

    const storeType = async (data) => {
        is_loading.value = true;
        errors.value = "";
        try {
            await axios.post("/types", data).then((response) => {
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
            console.log(e);
            if (e.response.status === 422) {
                errors.value = e.response.data;
                is_success.value = false;
            }
        }
    };

    const updateType = async (updated_type) => {
        errors.value = "";
        try {
            is_loading.value = true;
            type.value = updated_type;
            await axios
                .patch(`/types/${type.value.id}`, type.value)
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

    const destroyType = async (id) => {
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
                    .delete(`/types/${id}`)
                    .then((response) => {
                        getTypes(query.value);
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
        is_success,
        is_loading,
        query,
        type,
        types,
        getTypes,
        getType,
        storeType,
        updateType,
        destroyType,
    };
}
