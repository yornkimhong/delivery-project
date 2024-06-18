<template>
    <div>
        <!-- Content Header -->
        <div class="content-header">
            <!-- Header content -->
        </div>

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Invoices List</h3>
                            </div>
                            <div class="card-body">
                                <!-- Add New Invoices Button -->
                                <button
                                    type="button"
                                    class="btn btn-primary-color"
                                    @click="openModal"
                                >
                                    <i class="fas fa-plus mr-1"></i>
                                    Add Invoice
                                </button>

                                <!-- Invoices Table -->
                                <table
                                    id="example1"
                                    class="table table-bordered table-striped"
                                >
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">
                                                Sender Name
                                            </th>
                                            <th class="text-center">
                                                Reciver Name
                                            </th>
                                            <th class="text-center">
                                                Payment Method
                                            </th>
                                            <th class="text-center">
                                                Sender Branch
                                            </th>
                                            <th class="text-center">
                                                Reciever Branch 
                                            </th>
                                            <th class="text-center">
                                                Quantity
                                            </th>
                                            <th class="text-center">
                                                Delivery Cost
                                            </th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(invoice, index) in invoices"
                                            :key="invoice.id"
                                        >
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ index + 1 }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ invoice.sender.name }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ invoice.receiver.receiver_name }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ invoice.payment_method.name}}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ invoice.sender_branch.name }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ invoice.receiver_branch.name }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ invoice.item_detail.quantity }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{
                                                    invoice.delivery_cost
                                                }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                <a
                                                    class="me-3"
                                                    href="#"
                                                    @click.prevent="
                                                        editInvoice(invoice)
                                                    "
                                                >
                                                    <i
                                                        class="fas fa-edit fs-5 text-warning"
                                                    ></i>
                                                </a>
                                                <a
                                                    href="#"
                                                    @click.prevent="
                                                        deleteInovice(
                                                            invoice.id
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Invoice Modal -->
        <div
            class="modal fade"
            id="createInvoiceModel"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
            ref="createInvoiceModel"
        >
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <span v-if="editing">Editing Invoice</span>
                            <span v-else>Add Invoice</span>
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            @click="closeModal"
                        ></button>
                    </div>

                    <form @submit.prevent="handleSubmit">
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- name Field -->
                                        <div class="mb-2">
                                            <label for="type" class="form-label"
                                                >Sender Name</label
                                            >
                                            <input
                                                type="text"
                                                v-model="formValues.name"
                                                class="form-control"
                                                placeholder="Enter name"
                                            />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <!-- Reciver Name Field -->
                                        <div class="mb-2">
                                            <label for="type" class="form-label"
                                                >Receiver Name</label
                                            >
                                            <input
                                                type="text"
                                                v-model="
                                                    formValues.receiver_name
                                                "
                                                class="form-control"
                                                placeholder="Enter Receiver name"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- phone Field -->
                                        <div class="mb-2">
                                            <label for="type" class="form-label"
                                                >Sender phone</label
                                            >
                                            <input
                                                type="text"
                                                v-model="formValues.phone"
                                                class="form-control"
                                                placeholder="Enter Sender Phone Number"
                                            />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <!-- Reciver Phone Field -->
                                        <div class="mb-2">
                                            <label for="type" class="form-label"
                                                >Receiver Phone</label
                                            >
                                            <input
                                                type="text"
                                                v-model="
                                                    formValues.receiver_phone
                                                "
                                                class="form-control"
                                                placeholder="Enter Receiver Phone"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- branch sender Method Field -->
                                        <div class="mb-2">
                                            <label
                                                for="payment_method"
                                                class="form-label"
                                                >Branch Sender</label
                                            >
                                            <select
                                                v-model="
                                                    formValues.sender_branch_id
                                                "
                                                class="form-control"
                                                required
                                            >
                                                <option
                                                    v-for="branchSender in branchSenders"
                                                    :key="branchSender.id"
                                                    :value="branchSender.id"
                                                >
                                                    {{ branchSender.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- branch receiver Method Field -->
                                        <div class="mb-2">
                                            <label
                                                for="payment_method"
                                                class="form-label"
                                                >Branch Receiver</label
                                            >
                                            <select
                                                v-model="
                                                    formValues.receiver_branch_id
                                                "
                                                class="form-control"
                                                required
                                            >
                                                <option
                                                    v-for="branchReceiver in branchReceivers"
                                                    :key="branchReceiver.id"
                                                    :value="branchReceiver.id"
                                                >
                                                    {{ branchReceiver.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <!-- insurances Method Field -->
                                        <div class="mb-2">
                                            <label
                                                for="payment_method"
                                                class="form-label"
                                                >Insurances</label
                                            >
                                            <select
                                                v-model="
                                                    formValues.insurance_id
                                                "
                                                class="form-control"
                                                required
                                            >
                                                <option
                                                    v-for="insurance in insurances"
                                                    :key="insurance.id"
                                                    :value="insurance.id"
                                                >
                                                    {{ insurance.type }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Penalty Method Field -->
                                        <div class="mb-2">
                                            <label
                                                for="penalty_id"
                                                class="form-label"
                                            >
                                                Penalty
                                            </label>
                                            <select
                                                v-model="formValues.penalty_id"
                                                class="form-control"
                                                required
                                            >
                                                <option
                                                    v-for="penalty in penaltys"
                                                    :key="penalty.id"
                                                    :value="penalty.id"
                                                    disabled
                                                >
                                                    {{ penalty.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- quantity Field -->
                                        <div class="mb-2">
                                            <label for="type" class="form-label"
                                                >quantity</label
                                            >
                                            <input
                                                type="number"
                                                v-model="formValues.quantity"
                                                class="form-control"
                                                placeholder="Enter Sender quantity"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- delivery_cost Field -->
                                        <div class="mb-2">
                                            <label for="type" class="form-label"
                                                >delivery cost</label
                                            >
                                            <input
                                                type="number"
                                                v-model="
                                                    formValues.delivery_cost
                                                "
                                                class="form-control"
                                                placeholder="Enter delivery cost"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Payment Method Field -->
                                        <div class="mb-2">
                                            <label
                                                for="payment_method"
                                                class="form-label"
                                                >Payment Method</label
                                            >
                                            <select
                                                v-model="
                                                    formValues.payment_method
                                                "
                                                class="form-control"
                                                required
                                            >
                                                <option
                                                    v-for="method in paymentMethods"
                                                    :key="method.id"
                                                    :value="method.id"
                                                >
                                                    {{ method.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Payment responsibiity Field -->
                                        <div class="mb-2">
                                            <label for="type" class="form-label"
                                                >Payment responsibiity</label
                                            >
                                            <select
                                                v-model="
                                                    formValues.payment_responsibiity
                                                "
                                                class="form-control"
                                                required
                                            >
                                                <option
                                                    value="0"
                                                    selected="selected"
                                                >
                                                    Not Pay
                                                </option>
                                                <option value="1">Pay</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- current_address Field -->
                                        <div class="mb-2">
                                            <label for="type" class="form-label"
                                                >current address</label
                                            >
                                            <input
                                                type="text"
                                                v-model="
                                                    formValues.current_address
                                                "
                                                class="form-control"
                                                placeholder="Enter current address"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label
                                                for="description"
                                                class="form-label"
                                                >Description</label
                                            >
                                            <textarea
                                                v-model="formValues.description"
                                                class="form-control"
                                                placeholder="Enter description"
                                                style="height: 150px"
                                            ></textarea>
                                        </div>
                                    </div>
                                </div>
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
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, reactive, onMounted } from "vue";
import Toastify from "toastify-js";
import "toastify-js/src/toastify.css";

const invoices = ref([]);
const editing = ref(false);
const formValues = reactive({
    id: null,
    name: "",
    receiver_name: "",
    phone: "",
    receiver_phone: "",
    sender_branch_id: null,
    receiver_branch_id: null,
    insurance_id: null,
    penalty_id: null,
    quantity: null,
    delivery_cost: null,
    payment_method: null,
    payment_responsibiity: 0,
    current_address: "",
    description: null,
});

const createInvoiceModel = ref(null);

const paymentMethods = ref([]);
const insurances = ref([]);
const penaltys = ref([]);
const branchSenders = ref([]);
const branchReceivers = ref([]);

const fetchInvoices = async () => {
    try {
        $.LoadingOverlay("show");
        const response = await axios.get("http://127.0.0.1:8000/api/invoices");
        invoices.value = response.data;
        $.LoadingOverlay("hide");
    } catch (error) {
        console.error("Error fetching invoices:", error);
        $.LoadingOverlay("hide");
    }
};

const fetchPaymentMethods = async () => {
    try {
        const response = await axios.get(
            "http://127.0.0.1:8000/api/paymentMethods"
        );
        paymentMethods.value = response.data;
        // Check if there are payment methods and set a default if available
        if (paymentMethods.value.length > 0) {
            formValues.payment_method = paymentMethods.value[1].id;
        } else {
            console.warn("No payment methods fetched.");
        }
    } catch (error) {
        console.error("Error fetching payment methods:", error);
    }
};
const fetchInsurance = async () => {
    try {
        const response = await axios.get(
            "http://127.0.0.1:8000/api/insurances"
        );
        insurances.value = response.data;
        if (insurances.value.length > 0) {
            formValues.insurance_id = insurances.value[0].id;
        } else {
            console.warn("No payment methods fetched.");
        }
    } catch (error) {
        console.error("Error fetching payment methods:", error);
    }
};
const fetchPenalty = async () => {
    try {
        const response = await axios.get("http://127.0.0.1:8000/api/penaltys");
        penaltys.value = response.data;
        if (penaltys.value.length > 0) {
            formValues.penalty_id = penaltys.value[0].id;
        } else {
            console.warn("No payment methods fetched.");
        }
    } catch (error) {
        console.error("Error fetching payment methods:", error);
    }
};
const fetchBranchSender = async () => {
    try {
        const response = await axios.get("http://127.0.0.1:8000/api/branchs");
        branchSenders.value = response.data;
        if (branchSenders.value.length > 0) {
            formValues.sender_branch_id = branchSenders.value[0].id;
        } else {
            console.warn("No payment methods fetched.");
        }
    } catch (error) {
        console.error("Error fetching payment methods:", error);
    }
};
const fetchBranchReceiver = async () => {
    try {
        const response = await axios.get("http://127.0.0.1:8000/api/branchs");
        branchReceivers.value = response.data;
        if (branchReceivers.value.length > 0) {
            formValues.receiver_branch_id = branchReceivers.value[1].id;
        } else {
            console.warn("No payment methods fetched.");
        }
    } catch (error) {
        console.error("Error fetching payment methods:", error);
    }
};
const resetForm = () => {
    formValues.id = null;
    formValues.name = "";
    formValues.receiver_name = "";
    formValues.phone = "";
    formValues.receiver_phone = "";
    formValues.sender_branch_id = branchSenders.value[0].id;;
    formValues.receiver_branch_id = branchReceivers.value[0].id;;
    formValues.insurance_id = insurances.value[0].id;;
    formValues.penalty_id = penaltys.value[0].id;;
    formValues.quantity = null;
    formValues.delivery_cost = null;
    formValues.payment_method = paymentMethods.value[1].id;
    formValues.payment_responsibiity = 0;
    formValues.current_address = "";
    formValues.description = null;


    editing.value = false;
};

const handleSubmit = async () => {
    if (editing.value) {
        await updateInvoice();
    } else {
        await createInvoice();
    }
};

// Create new invoice
const createInvoice = async () => {
    try {
        const response = await axios.post(
            "http://127.0.0.1:8000/api/invoices",
            formValues
        );
        invoices.value.push(response.data);
        Toastify({
            text: "Invoice created successfully!",
            duration: 2000,
            gravity: "top",
            position: "right",
            close: false,
            style: {
                background: "linear-gradient(to right, #00b09b, #96c93d)",
                color: "#fff",
            },
        }).showToast();
        closeModal();
        resetForm();
    } catch (error) {
        console.error("Error creating invoice:", error);
        // Log detailed error response from server
        console.log("Error response:", error.response);
        Toastify({
            text: "Error creating invoice. Please try again.",
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
// Edit invoice function
const editInvoice = (invoice) => {
    editing.value = true;
    formValues.id = invoice.id;
    formValues.name = invoice.sender ? invoice.sender.name : "";
    formValues.receiver_name = invoice.receiver ? invoice.receiver.receiver_name : "";
    formValues.phone = invoice.sender ? invoice.sender.phone : "";
    formValues.receiver_phone = invoice.receiver ? invoice.receiver.phone : "";
    formValues.sender_branch_id = invoice.sender_branch ? invoice.sender_branch.id : null;
    formValues.receiver_branch_id = invoice.receiver_branch ? invoice.receiver_branch.id : null;
    formValues.insurance_id = invoice.insurance ? invoice.insurance.id : null;
    formValues.penalty_id = invoice.penalty ? invoice.penalty.id : null;
    formValues.quantity = invoice.item_detail ? invoice.item_detail.quantity : null;
    formValues.delivery_cost = invoice.delivery_cost || null;
    formValues.payment_method = invoice.payment_method ? invoice.payment_method.id : null;
    formValues.payment_responsibility = invoice.payment_responsibility || 0; // Corrected spelling
    formValues.current_address = invoice.receiver_branch ? invoice.receiver_branch.location : "";
    formValues.description = invoice.item_detail ? invoice.item_detail.description : "";

    openModal();
};





// update
const updateInvoice = async () => {
    try {
        const response = await axios.put(
            `http://127.0.0.1:8000/api/invoices/${formValues.id}`,
            formValues
        );

        // Update the 'invoices' array after successful update
        const updatedInvoice = response.data;

        // Find the index of the updated invoice in 'invoices' array
        const index = invoices.value.findIndex(inv => inv.id === updatedInvoice.id);

        if (index !== -1) {
            // Update the invoice in 'invoices' array
            invoices.value.splice(index, 1, updatedInvoice);
        }

        Toastify({
            text: "Invoice updated successfully!",
            duration: 2000,
            gravity: "top",
            position: "right",
            close: false,
            style: {
                background: "linear-gradient(to right, #ffd166, #ffd166 )",
                color: "#fff",
            },
        }).showToast();

        closeModal(); // Close modal after successful update
        resetForm(); // Reset form values
    } catch (error) {
        console.error("Error updating Invoice:", error);

        Toastify({
            text: "Error updating Invoice. Please try again.",
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

// delete
const deleteInovice = async (InvoiceID) => {
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
            await axios.delete(
                `http://127.0.0.1:8000/api/invoices/${InvoiceID}`
            );

            $.LoadingOverlay("show");
            // Filter out deleted user from users array
            invoices.value = invoices.value.filter(
                (invoice) => invoice.id !== InvoiceID
            );
            $.LoadingOverlay("hide");
            // Show success toast message
            Toastify({
                text: "Invoices deleted successfully!",
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
            text: "Error deleting invoices. Please try again.",
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

// Modal control functions
const openModal = () => {
    $(createInvoiceModel.value).modal("show");
};

const closeModal = () => {
    resetForm();
    $(createInvoiceModel.value).modal("hide");
};


onMounted(() => {
    fetchInvoices();
    fetchPaymentMethods();
    fetchInsurance();
    fetchPenalty();
    fetchBranchSender();
    fetchBranchReceiver();
});
</script>

<style></style>
