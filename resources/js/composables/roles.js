import { ref, computed } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import Swal from "sweetalert2";

export default function useRoles() {
    const role = ref(null);
    const roles = ref([]);
    const is_loading = ref(false);
    const pagination = ref({});
    const query = ref({
        search: null,
        page: 1,
    });

    const errors = ref("");
    const router = useRouter();

    const getRoles = async (params = {}) => {
        is_loading.value = true;

        let query_str = { ...query.value, ...params };
        console.log(query_str);
        await axios
            .get("/roles?page=" + query.value.page, query_str)
            .then((response) => {
                roles.value = response.data.data;
                pagination.value = response.data.meta;
                is_loading.value = false;
            });
    };

    const getRole = async (id) => {
        let response = await axios.get(`/roles/${id}`);
        role.value = response.data;
        is_loading.value = false;
    };

    const storeRole = async (data) => {
        is_loading.value = true;
        errors.value = "";
        try {
            await axios.post("/roles", data).then((response) => {
                Swal.fire({
                    title: "Success",
                    icon: "success",
                    text: response.data.message,
                });
                is_loading.value = false;
            });
        } catch (e) {
            console.log(e);
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value = e.response.data.errors;
                }
            }
        }
    };

    const updateRole = async (updated_role) => {
        errors.value = "";
        try {
            is_loading.value = true;
            role.value = updated_role;
            await axios
                .patch(`/roles/${role.value.id}`, role.value)
                .then((response) => {
                    Swal.fire({
                        title: "Success",
                        icon: "success",
                        text: response.data.message,
                    });
                    is_loading.value = false;
                });
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value = e.response.data.errors;
                }
            }
        }
    };

    const destroyRole = async (id) => {
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
                    .delete(`/roles/${id}`)
                    .then((response) => {
                        getRoles(query.value);
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
        role,
        roles,
        getRoles,
        getRole,
        storeRole,
        updateRole,
        destroyRole,
    };
}