import { ref, computed } from "vue";
import axios from "axios";
import Swal from "sweetalert2";

export default function usePermits() {
    const permit = ref(null);
    const permits = ref([]);
    const is_permitsuccess = ref(false);
    const is_loading = ref(false);
    const pagination = ref({});
    const query = ref({
        search: null,
        page: 1,
    });

    const permiterrors = ref({});

    const getPermits = async (params = {}, type = "") => {
        is_loading.value = true;

        let query_str = { ...query.value, ...params };
        let url = type == "client" ? "/form/permits" : "/permits";
        await axios
            .get(`${url}?page=${query.value.page}`, { params: query_str })
            .then((response) => {
                permits.value = response.data.data;
                pagination.value = response.data.meta;
                is_loading.value = false;
            });
    };

    const getPermit = async (id) => {
        let response = await axios.get(`/permits/${id}`);
        permit.value = response.data;
        is_loading.value = false;
    };

    const storePermit = async (data) => {
        is_loading.value = true;
        permiterrors.value = "";
        try {
            await axios.post("/permits", data).then((response) => {
                Swal.fire({
                    title: "Success",
                    icon: "success",
                    text: response.data.message,
                });
                permiterrors.value = {};
                is_loading.value = false;
                is_permitsuccess.value = true;
            });
        } catch (e) {
            console.log(e);
            if (e.response.status === 422) {
                permiterrors.value = e.response.data;
                is_permitsuccess.value = false;
            }
        }
    };

    const updatePermit = async (updated_permit) => {
        permiterrors.value = "";
        try {
            is_loading.value = true;
            permit.value = updated_permit;
            await axios
                .patch(`/permits/${permit.value.id}`, permit.value)
                .then((response) => {
                    Swal.fire({
                        title: "Success",
                        icon: "success",
                        text: response.data.message,
                    });
                    permiterrors.value = {};
                    is_loading.value = false;
                    is_permitsuccess.value = true;
                });
        } catch (e) {
            if (e.response.status === 422) {
                permiterrors.value = e.response.data;
                is_permitsuccess.value = false;
            }
        }
    };

    const destroyPermit = async (id) => {
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
                    .delete(`/permits/${id}`)
                    .then((response) => {
                        getPermits(query.value);
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
        permiterrors,
        pagination,
        is_permitsuccess,
        is_loading,
        query,
        permit,
        permits,
        getPermits,
        getPermit,
        storePermit,
        updatePermit,
        destroyPermit,
    };
}
