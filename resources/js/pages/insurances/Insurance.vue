<template>
    <div>
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Insurances</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Insurances</li>
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
                                <h3 class="card-title">Insurance List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- Add New Insurance Button -->
                                <button
                                    type="button"
                                    class="btn btn-primary-color"
                                    @click="openModal"
                                >
                                    <i class="fas fa-plus mr-1"></i>
                                    Add Insurance
                                </button>

                                <!-- Branch Table -->
                                <table
                                    id="example1"
                                    class="table table-bordered table-striped"
                                >
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-center">Fee</th>
                                            
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(insurance, index) in insurances"
                                            :key="insurance.id"
                                        >
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ index + 1 }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ insurance.type }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ insurance.fee }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                <a
                                                    class="me-3"
                                                    href="#"
                                                    @click.prevent="
                                                        editInsurance(insurance)
                                                    "
                                                >
                                                    <i
                                                        class="fas fa-edit fs-5 text-warning"
                                                    ></i>
                                                </a>
                                                <a
                                                    href="#"
                                                    @click.prevent="
                                                        deleteInsurance(insurance.id)
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
            id="createInsuranceModel"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
            ref="createInsuranceModel"
        >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <span v-if="editing">Editing Insurance</span>
                            <span v-else>Add Insurance</span>
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            @click="closeModal"
                        ></button>
                    </div>

                    <form @submit.prevent="handleSubmit">
                        <div class="modal-body">
                            <!-- Type Field -->
                            <div class="mb-2">
                                <label for="type" class="form-label"
                                    >Type</label
                                >
                                <input
                                    type="text"
                                    v-model="formValues.type"
                                    class="form-control"
                                    placeholder="Enter type"
                                />
                            </div>

                            <!-- Fee Field -->
                            <div class="mb-2">
                                <label for="fee" class="form-label"
                                    >Fee</label
                                >
                                <input
                                    type="text"
                                    v-model="formValues.fee"
                                    class="form-control"
                                    placeholder="Enter Fee"
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

const insurances = ref([]);
const editing = ref(false);
const formValues = reactive({
    id: null,
    type: "",
    fee: "",

});
const createInsuranceModel = ref(null);

const fetchInsurance = async () => {
    try {
        $.LoadingOverlay("show");
        const response = await axios.get("http://127.0.0.1:8000/api/insurances");
        insurances.value = response.data;
        $.LoadingOverlay("hide");
    } catch (error) {
        console.error("Error fetching Insurances:", error);
        $.LoadingOverlay("hide");
    }
};

const resetForm = () => {
    formValues.id = null;
    formValues.type = "";
    formValues.fee = "";
    editing.value = false;
};

const openModal = () => {
    resetForm();
    $(createInsuranceModel.value).modal("show");
};

const closeModal = () => {
    $(createInsuranceModel.value).modal("hide");
};

const handleSubmit = async () => {
    if (editing.value) {
        await updateInsurance();
    } else {
        await createInsurance();
    }
};

const createInsurance = async () => {
     try {
        const response = await axios.post(
            "http://127.0.0.1:8000/api/insurances",
            formValues
        );
        insurances.value.push(response.data);

        Toastify({
            text: "Insurance created successfully!",
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
            text: "Error creating Insurance. Please try again.",
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
const editInsurance = (insurance) => {
    formValues.id = insurance.id;
    formValues.type = insurance.type;
    formValues.fee = insurance.fee;
    editing.value = true;
    $(createInsuranceModel.value).modal("show");
};
const updateInsurance = async () => {
     try {
        const response = await axios.put(
            `http://127.0.0.1:8000/api/insurances/${formValues.id}`,
            formValues
        );

        const index = insurances.value.findIndex(
            (insurance) => insurance.id === formValues.id
        );
        if (index !== -1) {
            insurances.value[index] = response.data;
        }

        Toastify({
            text: "Insurance updated successfully!",
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
        console.error("Error updating Insurance:", error);
        Toastify({
            text: "Error updating Insurance. Please try again.",
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

const deleteInsurance = async (Insuranceid) => {
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
            await axios.delete(`http://127.0.0.1:8000/api/insurances/${Insuranceid}`);

            $.LoadingOverlay("show");
            // Filter out deleted user from users array
            insurances.value = insurances.value.filter((insurance) => insurance.id !== Insuranceid);
            $.LoadingOverlay("hide");
            // Show success toast message
            Toastify({
                text: "Insurance deleted successfully!",
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
            text: "Error deleting Insurance. Please try again.",
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
    fetchInsurance();
});
</script>

<style></style>
