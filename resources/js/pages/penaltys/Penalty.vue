<template>
    <div>
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Penalty</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Penalty</li>
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
                                <h3 class="card-title">Penalty List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- Add New Penalty Button -->
                                <button
                                    type="button"
                                    class="btn btn-primary-color"
                                    @click="openModal"
                                >
                                    <i class="fas fa-plus mr-1"></i>
                                    Add Penalty
                                </button>

                                <!-- Branch Table -->
                                <table
                                    id="example1"
                                    class="table table-bordered table-striped"
                                >
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">name</th>
                                            <th class="text-center">
                                                descrition
                                            </th>

                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(penalty, index) in penaltys"
                                            :key="penalty.id"
                                        >
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ index + 1 }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ penalty.name }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ penalty.description }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                <a
                                                    class="me-3"
                                                    href="#"
                                                    @click.prevent="
                                                        editPenalty(penalty)
                                                    "
                                                >
                                                    <i
                                                        class="fas fa-edit fs-5 text-warning"
                                                    ></i>
                                                </a>
                                                <a
                                                    href="#"
                                                    @click.prevent="
                                                        deletePenalty(
                                                            penalty.id
                                                        )
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
            id="createPenaltyModel"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
            ref="createPenaltyModel"
        >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <span v-if="editing">Editing Penalty</span>
                            <span v-else>Add Penalty</span>
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            @click="closeModal"
                        ></button>
                    </div>

                    <form @submit.prevent="handleSubmit">
                        <div class="modal-body">
                            <!-- name Field -->
                            <div class="mb-2">
                                <label for="name" class="form-label"
                                    >Name</label
                                >
                                <input
                                    type="text"
                                    v-model="formValues.name"
                                    class="form-control"
                                    placeholder="Enter Name"
                                />
                            </div>

                            <!-- description Field -->
                            <div class="mb-2">
                                <label for="description" class="form-label"
                                    >Description</label
                                >
                                <textarea
                                    v-model="formValues.description"
                                    class="form-control"
                                    placeholder="Enter description"
                                    style="height: 150px;"
                                ></textarea>
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

const penaltys = ref([]);
const editing = ref(false);
const formValues = reactive({
    id: null,
    name: "",
    decription: "",
});
const createPenaltyModel = ref(null);

const fetchPenalty = async () => {
    try {
        $.LoadingOverlay("show");
        const response = await axios.get(
            "http://127.0.0.1:8000/api/penaltys"
        );
        penaltys.value = response.data;
        $.LoadingOverlay("hide");
    } catch (error) {
        console.error("Error fetching Penaltys:", error);
        $.LoadingOverlay("hide");
    }
};

const resetForm = () => {
    formValues.id = null;
    formValues.name = "";
    formValues.description = "";
    editing.value = false;
};

const openModal = () => {
    resetForm();
    $(createPenaltyModel.value).modal("show");
};

const closeModal = () => {
    $(createPenaltyModel.value).modal("hide");
};

const handleSubmit = async () => {
    if (editing.value) {
        await updatePenalty();
    } else {
        await createPenalty();
    }
};

const createPenalty = async () => {
    try {
        const response = await axios.post(
            "http://127.0.0.1:8000/api/penaltys",
            formValues
        );
        penaltys.value.push(response.data);

        Toastify({
            text: "Penalty created successfully!",
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
            text: "Error creating Penalty. Please try again.",
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
const editPenalty = (penalty) => {
    formValues.id = penalty.id;
    formValues.name = penalty.name;
    formValues.description = penalty.description;
    editing.value = true;
    $(createPenaltyModel.value).modal("show");
};
const updatePenalty = async () => {
    try {
        const response = await axios.put(
            `http://127.0.0.1:8000/api/penaltys/${formValues.id}`,
            formValues
        );

        const index = penaltys.value.findIndex(
            (penalty) => penalty.id === formValues.id
        );
        if (index !== -1) {
            penaltys.value[index] = response.data;
        }

        Toastify({
            text: "Penalty updated successfully!",
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
        console.error("Error updating Penalty:", error);
        Toastify({
            text: "Error updating Penalty. Please try again.",
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

const deletePenalty = async (Penaltyid) => {
    try {
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
            await axios.delete(
                `http://127.0.0.1:8000/api/penaltys/${Penaltyid}`
            );

            $.LoadingOverlay("show");
            // Filter out deleted user from users array
            penaltys.value = penaltys.value.filter(
                (penalty) => penalty.id !== Penaltyid
            );
            $.LoadingOverlay("hide");
            // Show success toast message
            Toastify({
                text: "Penalty deleted successfully!",
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
        Toastify({
            text: "Error deleting Penalty. Please try again.",
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
    fetchPenalty();
});
</script>

<style></style>
