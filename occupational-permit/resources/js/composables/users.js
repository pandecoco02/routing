import { ref } from "vue";
import axios from "axios";
import Swal from "sweetalert2";

export default function useUsers() {
    const user = ref(null);
    const users = ref([]);
    const is_success = ref(false);
    const is_loading = ref(false);
    const pagination = ref({});
    const query = ref({
        search: null,
        page: 1,
    });

    const errors = ref({});

    const getUsers = async (params = {}, type = "") => {
        is_loading.value = true;

        let query_str = { ...query.value, ...params };
        let url = type == "client" ? "/form/users" : "/users";
        await axios
            .get(`${url}?page=${query.value.page}`, { params: query_str })
            .then((response) => {
                users.value = response.data.data;
                pagination.value = response.data.meta;
                is_loading.value = false;
            });
    };

    const getUser = async (id) => {
        let response = await axios.get(`/users/${id}`);
        user.value = response.data;
        is_loading.value = false;
    };

    const storeUser = async (data) => {
        is_loading.value = true;
        errors.value = "";
        try {
            await axios.post("/users", data).then((response) => {
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

    const updateUser = async (updated_user) => {
        errors.value = "";
        try {
            is_loading.value = true;
            user.value = updated_user;
            await axios
                .patch(`/users/${user.value.id}`, user.value)
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

    const destroyUser = async (id) => {
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
                    .delete(`/users/${id}`)
                    .then((response) => {
                        getUsers(query.value);
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
        user,
        users,
        getUsers,
        getUser,
        storeUser,
        updateUser,
        destroyUser,
    };
}
