<template>
    <div>
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Payment Method</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active">paymentMethod</li>
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
                                <h3 class="card-title">Payment Method List</h3>
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
                                    Add Payment Method
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
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(paymentMethod, index) in paymentMethods"
                                            :key="paymentMethod.id"
                                        >
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ index + 1 }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ paymentMethod.name }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                <a
                                                    class="me-3"
                                                    href="#"
                                                    @click.prevent="
                                                        editPaymentMethod(paymentMethod)
                                                    "
                                                >
                                                    <i
                                                        class="fas fa-edit fs-5 text-warning"
                                                    ></i>
                                                </a>
                                                <a
                                                    href="#"
                                                    @click.prevent="
                                                        deletePaymentMethod(paymentMethod.id)
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
            id="createPaymentMethodModal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
            ref="createPaymentMethodModal"
        >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <span v-if="editing">Editing Payment method</span>
                            <span v-else>Add Payment Method</span>
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

const paymentMethods = ref([]);
const editing = ref(false);
const formValues = reactive({
    id: null,
    name: "",
});
const createPaymentMethodModal = ref(null);

const fetchPaymentMethod = async () => {
    try {
        $.LoadingOverlay("show");
        const response = await axios.get("http://127.0.0.1:8000/api/paymentMethods");
        paymentMethods.value = response.data;
        $.LoadingOverlay("hide");
    } catch (error) {
        console.error("Error fetching PaymentMethod:", error);
        $.LoadingOverlay("hide");
    }
};

const resetForm = () => {
    formValues.id = null;
    formValues.name = "";
    editing.value = false;
};

const openModal = () => {
    resetForm();
    $(createPaymentMethodModal.value).modal("show");
};

const closeModal = () => {
    $(createPaymentMethodModal.value).modal("hide");
};

const handleSubmit = async () => {
    if (editing.value) {
        await updatePaymentMethod();
    } else {
        await createPaymentMethod();
    }
};

const createPaymentMethod = async () => {
     try {
        const response = await axios.post(
            "http://127.0.0.1:8000/api/paymentMethods",
            formValues
        );
        paymentMethods.value.push(response.data);

        Toastify({
            text: "Payment Method created successfully!",
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
            text: "Error creating Payment Method. Please try again.",
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
const editPaymentMethod = (paymentMethod) => {
    formValues.id = paymentMethod.id;
    formValues.name = paymentMethod.name;
    editing.value = true;
    $(createPaymentMethodModal.value).modal("show");
};
const updatePaymentMethod = async () => {
     try {
        const response = await axios.put(
            `http://127.0.0.1:8000/api/paymentMethods/${formValues.id}`,
            formValues
        );
        const index = paymentMethods.value.findIndex(
            (paymentMethod) => paymentMethod.id === formValues.id
        );
        if (index !== -1) {
            paymentMethods.value[index] = response.data;
        }
        Toastify({
            text: "Payment Method updated successfully!",
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
        Toastify({
            text: "Error updating Payment Method. Please try again.",
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

const deletePaymentMethod = async (PaymentMethodid) => {
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
        if (result.isConfirmed) {
            await axios.delete(`http://127.0.0.1:8000/api/paymentMethods/${PaymentMethodid}`);
            $.LoadingOverlay("show");
            paymentMethods.value = paymentMethods.value.filter((paymentMethod) => paymentMethod.id !== PaymentMethodid);
            $.LoadingOverlay("hide");
            Toastify({
                text: "Payment Method deleted successfully!",
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
            text: "Error deleting Payment Method. Please try again.",
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
    fetchPaymentMethod();
});
</script>

<style></style>
