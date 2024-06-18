<template>
    <div>
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Users</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">User List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- Add New User Button -->
                                <button
                                    type="button"
                                    class="btn btn-primary-color"
                                    @click="openModal"
                                >
                                    <i class="fas fa-plus mr-1"></i>
                                    ADD User
                                </button>

                                <!-- User Table -->
                                <table
                                    id="example1"
                                    class="table table-bordered table-striped"
                                >
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Phone</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(user, index) in users"
                                            :key="user.id"
                                        >
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ index + 1 }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ user.name }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ user.email }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ user.phone }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                <a
                                                    class="me-3"
                                                    href="#"
                                                    @click.prevent="
                                                        editUser(user)
                                                    "
                                                >
                                                    <i
                                                        class="fas fa-edit fs-5 text-warning"
                                                    ></i>
                                                </a>
                                                <a
                                                    href="#"
                                                    @click.prevent="
                                                        deleteUser(user.id)
                                                    "
                                                >
                                                    <i
                                                        class="fas fa-trash-alt text-danger fs-5"
                                                    ></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->

        <!-- User Creation Modal -->
        <div
            class="modal fade"
            id="createUserModal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
            ref="createUserModal"
        >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <span v-if="editing">Editing User</span>
                            <span v-else>Add User</span>
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            @click="closeModal"
                        ></button>
                    </div>

                    <form @submit.prevent="handleSubmit">
                        <div class="modal-body">
                            <!-- Name Field -->
                            <div class="mb-2">
                                <label for="name" class="form-label"
                                    >Name</label
                                >
                                <input
                                    type="text"
                                    v-model="formValues.name"
                                    class="form-control"
                                    placeholder="Enter name"
                                />
                            </div>

                            <!-- Email Field -->
                            <div class="mb-2">
                                <label for="email" class="form-label"
                                    >Email</label
                                >
                                <input
                                    type="email"
                                    v-model="formValues.email"
                                    class="form-control"
                                    placeholder="Enter email"
                                />
                            </div>
                            <!-- Phone Field -->
                            <div class="mb-2">
                                <label for="phone" class="form-label"
                                    >Phone</label
                                >
                                <input
                                    type="text"
                                    v-model="formValues.phone"
                                    class="form-control"
                                    placeholder="Enter phone"
                                />
                            </div>

                            <!-- Password Fields -->
                            <div class="mb-2">
                                <label for="password" class="form-label"
                                    >Password</label
                                >
                                <input
                                    type="password"
                                    v-model="formValues.password"
                                    class="form-control"
                                    placeholder="Enter password"
                                />
                            </div>

                            <div class="mb-2" v-if="!editing">
                                <label
                                    for="password_confirmation"
                                    class="form-label"
                                    >Confirm Password</label
                                >
                                <input
                                    type="password"
                                    v-model="formValues.password_confirmation"
                                    class="form-control"
                                    placeholder="Confirm password"
                                />
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                @click="closeModal"
                            >
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary-color">
                                <span v-if="editing">Edit</span>
                                <span v-else>Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.modal -->
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, reactive, onMounted } from "vue";
import Toastify from "toastify-js";
import "toastify-js/src/toastify.css";

const users = ref([]);
const editing = ref(false);
const formValues = reactive({
    id: null,
    name: "",
    email: "",
    phone: "",
    password: "",
    password_confirmation: "",
});
const createUserModal = ref(null);

const fetchUsers = async () => {
    try {
        $.LoadingOverlay("show");
        const response = await axios.get("http://127.0.0.1:8000/api/users");
        users.value = response.data;
        $.LoadingOverlay("hide");
    } catch (error) {
        console.error("Error fetching users:", error);
        $.LoadingOverlay("hide");
    }
};

const resetForm = () => {
    formValues.id = null;
    formValues.name = "";
    formValues.email = "";
    formValues.phone = "";
    formValues.password = "";
    formValues.password_confirmation = "";
    editing.value = false;
};

const openModal = () => {
    resetForm();
    $(createUserModal.value).modal("show");
};

const closeModal = () => {
    $(createUserModal.value).modal("hide");
};

const handleSubmit = async () => {
    if (editing.value) {
        await updateUser();
    } else {
        await createUser();
    }
};

const createUser = async () => {
    try {
        if (formValues.password !== formValues.password_confirmation) {
            Toastify({
                text: "Password is not match. try again",
                duration: 2000,
                gravity: "top",
                position: "right",
                close: false,
                style: {
                    background: "linear-gradient(to right, #ff5f6d, #ffc371)",
                    color: "#fff",
                },
            }).showToast();
            return;
        }
        const response = await axios.post(
            "http://127.0.0.1:8000/api/users",
            formValues
        );
        users.value.push(response.data);

        Toastify({
            text: "User created successfully!",
            duration: 2000,
            gravity: "top",
            position: "right",
            close: false,
            style: {
                background: "linear-gradient(to right, #00b09b, #96c93d)",
                color: "#fff",
            },
        }).showToast();
        $.LoadingOverlay("show");

        closeModal();
        $.LoadingOverlay("hide");
    } catch (error) {
        Toastify({
            text: "Error creating user. Please try again.",
            duration: 2000,
            gravity: "top",
            position: "right",
            close: false,
            style: {
                background: "linear-gradient(to right, #ff5f6d, #ffc371)",
                color: "#fff",
            },
        }).showToast();
    }
};

const editUser = (user) => {
    formValues.id = user.id;
    formValues.name = user.name;
    formValues.email = user.email;
    formValues.phone = user.phone;
    formValues.password = user.password;
    editing.value = true;
    $(createUserModal.value).modal("show");
};

// code for update
const updateUser = async () => {
    try {
        const response = await axios.put(
            `http://127.0.0.1:8000/api/users/${formValues.id}`,
            formValues
        );

        const index = users.value.findIndex(
            (user) => user.id === formValues.id
        );
        if (index !== -1) {
            users.value[index] = response.data;
        }

        Toastify({
            text: "User updated successfully!",
            duration: 2000,
            gravity: "top",
            position: "right",
            close: false,
            style: {
                background: "linear-gradient(to right, #ffd166, #ffd166 )",
                color: "#fff",
            },
        }).showToast();
        $.LoadingOverlay("show");

        closeModal();
        $.LoadingOverlay("hide");
    } catch (error) {
        console.error("Error updating user:", error);
        Toastify({
            text: "Error updating user. Please try again.",
            duration: 2000,
            gravity: "top",
            position: "right",
            close: false,
            style: {
                background: "linear-gradient(to right, #ff5f6d, #ffc371)",
                color: "#fff",
            },
        }).showToast();
    }
};

// Delete user
const deleteUser = async (userId) => {
    try {
        // Show confirmation alert using SweetAlert2
        const result = await Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        });

        // If user confirms deletion
        if (result.isConfirmed) {
            // Make DELETE request to delete user
            await axios.delete(`http://127.0.0.1:8000/api/users/${userId}`);

            $.LoadingOverlay("show");
            // Filter out deleted user from users array
            users.value = users.value.filter((user) => user.id !== userId);
            $.LoadingOverlay("hide");
            // Show success toast message
            Toastify({
                text: "User deleted successfully!",
                duration: 2000,
                gravity: "top",
                position: "right",
                close: false,
                style: {
                    background: "linear-gradient(to right, #ff5f6d, #ffc371)",
                    color: "#fff",
                },
            }).showToast();
        }
    } catch (error) {
        // Log and handle error if deleting user fails
        console.error("Error deleting user:", error);

        // Show error toast message
        Toastify({
            text: "Error deleting user. Please try again.",
            duration: 2000,
            gravity: "top",
            position: "right",
            close: false,
            style: {
                background: "linear-gradient(to right, #ff5f6d, #ffc371)",
                color: "#fff",
            },
        }).showToast();
    }
};

onMounted(() => {
    fetchUsers();
});
</script>

<style scoped>
/* Add your scoped styles here */
</style>
