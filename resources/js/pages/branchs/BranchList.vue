<template>
    <div>
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Branchs</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Branchs</li>
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
                                <h3 class="card-title">Branch List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- Add New Branch Button -->
                                <button
                                    type="button"
                                    class="btn btn-primary-color"
                                    @click="openModal"
                                >
                                    <i class="fas fa-plus mr-1"></i>
                                    Add Branch
                                </button>

                                <!-- Branch Table -->
                                <table
                                    id="example1"
                                    class="table table-bordered table-striped"
                                >
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Phone</th>
                                            <th class="text-center">
                                                Alt_phone
                                            </th>
                                            <th class="text-center">
                                                Location
                                            </th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(branch, index) in branchs"
                                            :key="branch.id"
                                        >
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ index + 1 }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ branch.name }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ branch.phone }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ branch.alt_phone }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ branch.location }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                <a
                                                    class="me-3"
                                                    href="#"
                                                    @click.prevent="
                                                        editBranch(branch)
                                                    "
                                                >
                                                    <i
                                                        class="fas fa-edit fs-5 text-warning"
                                                    ></i>
                                                </a>
                                                <a
                                                    href="#"
                                                    @click.prevent="
                                                        deleteBranch(branch.id)
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
            id="createBranchModal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
            ref="createBranchModal"
        >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <span v-if="editing">Editing Branch</span>
                            <span v-else>Add Branch</span>
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

                            <!-- phone Field -->
                            <div class="mb-2">
                                <label for="phone" class="form-label"
                                    >phone</label
                                >
                                <input
                                    type="phone"
                                    v-model="formValues.phone"
                                    class="form-control"
                                    placeholder="Enter phone"
                                />
                            </div>
                            <!-- alt_phone Field -->
                            <div class="mb-2">
                                <label for="alt_phone" class="form-label"
                                    >alt_phone</label
                                >
                                <input
                                    type="text"
                                    v-model="formValues.alt_phone"
                                    class="form-control"
                                    placeholder="Enter alt_phone"
                                />
                            </div>
                            <!-- location Field -->
                            <div class="mb-2">
                                <label for="location" class="form-label"
                                    >location</label
                                >
                                <input
                                    type="text"
                                    v-model="formValues.location"
                                    class="form-control"
                                    placeholder="Enter location"
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

const branchs = ref([]);
const editing = ref(false);
const formValues = reactive({
    id: null,
    name: "",
    phone: "",
    alt_phone: "",
    location: "",
});
const createBranchModal = ref(null);

const fetchBranch = async () => {
    try {
        $.LoadingOverlay("show");
        const response = await axios.get("http://127.0.0.1:8000/api/branchs");
        branchs.value = response.data;
        $.LoadingOverlay("hide");
    } catch (error) {
        console.error("Error fetching users:", error);
        $.LoadingOverlay("hide");
    }
};

const resetForm = () => {
    formValues.id = null;
    formValues.name = "";
    formValues.phone = "";
    formValues.alt_phone = "";
    formValues.location = "";
    editing.value = false;
};

const openModal = () => {
    resetForm();
    $(createBranchModal.value).modal("show");
};

const closeModal = () => {
    $(createBranchModal.value).modal("hide");
};

const handleSubmit = async () => {
    if (editing.value) {
        await updateBranch();
    } else {
        await createBranch();
    }
};

const createBranch = async () => {
     try {
        const response = await axios.post(
            "http://127.0.0.1:8000/api/branchs",
            formValues
        );
        branchs.value.push(response.data);

        Toastify({
            text: "Branch created successfully!",
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
            text: "Error creating Branch. Please try again.",
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
const editBranch = (branch) => {
    formValues.id = branch.id;
    formValues.name = branch.name;
    formValues.phone = branch.phone;
    formValues.alt_phone = branch.alt_phone;
    formValues.location = branch.location;
    editing.value = true;
    $(createBranchModal.value).modal("show");
};
const updateBranch = async () => {
     try {
        const response = await axios.put(
            `http://127.0.0.1:8000/api/branchs/${formValues.id}`,
            formValues
        );

        const index = branchs.value.findIndex(
            (branch) => branch.id === formValues.id
        );
        if (index !== -1) {
            branchs.value[index] = response.data;
        }

        Toastify({
            text: "Branch updated successfully!",
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
        console.error("Error updating Branch:", error);
        Toastify({
            text: "Error updating Branch. Please try again.",
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

const deleteBranch = async (Branchid) => {
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
            await axios.delete(`http://127.0.0.1:8000/api/branchs/${Branchid}`);

            $.LoadingOverlay("show");
            // Filter out deleted user from users array
            branchs.value = branchs.value.filter((branch) => branch.id !== Branchid);
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
    fetchBranch();
});
</script>

<style></style>
