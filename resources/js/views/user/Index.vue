<script setup lang="ts">
import { ref, onMounted } from "vue";
import UserForm from "../../components/users/Form.vue";
import useUsers from "../../composables/users";
import { VDataTable } from "vuetify/labs/VDataTable";

const { users, pagination, query, is_loading, getUsers, destroyUser } =
    useUsers();

const user = ref({});
const show_form_modal = ref(false);
const headers = [
    { title: "Name", key: "name" },
    { title: "Email", key: "email" },
    { title: "Roles", key: "user_roles" },
    { title: "", key: "actions" },
];
onMounted(() => {
    reloadUsers();
});

const reloadUsers = async () => {
    await getUsers();
    user.value = {};
};

const updateUser = async (row) => {
    user.value = row;
    show_form_modal.value = true;
    console.log(user.value);
};
const deleteUser = async (id) => {
    await destroyUser(id);
};

const showUserForm = async (is_show) => {
    user.value = {};
    show_form_modal.value = is_show;
};
</script>
<template>
    <div style="text-align: end">
        <v-btn
            class="ma-2"
            color="blue-darken-1"
            @click="showUserForm(true)"
        >
            <v-icon start icon="mdi-plus"></v-icon>
            User
        </v-btn>
    </div>
    <v-card>
        <div
            class="overflow-hidden overflow-x-auto min-w-full align-middle sm:rounded-md"
        >
            <v-card-title>List of Users </v-card-title>
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
                :items="users"
                :search="query.search"
                class="elevation-1"
                :loading="is_loading"
                loading-text="Loading... Please wait"
            >
                <template v-slot:item.name="{ item }">
                    {{ item.raw.first_name +
                        " " +
                        (item.raw.middle_name ? item.raw.middle_name : "") +
                        " " +
                        item.raw.last_name +
                        " " +
                        (item.raw.extension_name ? item.raw.extension_name : "")
                    }}
                </template>
                <template v-slot:item.user_roles="{ item }">
                    <span v-for="role in item.raw.roles">
                        {{ role.name }},
                    </span>
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
                                    color="green"
                                    @click="updateUser(item.raw)"
                                    size="small"
                                >
                                    Edit
                                    <v-icon end icon="mdi-pencil"></v-icon>
                                </v-btn>
                                <v-btn
                                    width="100%"
                                    class="mt-2"
                                    color="red"
                                    @click="deleteUser(item.raw.id)"
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
                                @click="getUsers"
                            ></v-pagination>
                        </div>
                    </div>
                </template>
            </v-data-table>
        </div>
    </v-card>
    <user-form
        :value="show_form_modal"
        :user="user"
        @reloadUsers="reloadUsers"
        @input="showUserForm"
    />
</template>
