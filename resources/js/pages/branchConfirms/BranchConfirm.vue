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
                                <h3 class="card-title">Branch Confirms List</h3>
                            </div>
                            <div class="card-body">
                                <!-- branchConfirms Table -->
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Sender Name</th>
                                            <th class="text-center">Sender Phone</th>
                                            <th class="text-center">Receiver Name</th>
                                            <th class="text-center">Receiver Phone</th>
                                            <th class="text-center">Confirm Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(branchConfirm, index) in branchConfirms" :key="branchConfirm.id">
                                            <td class="text-center align-middle">{{ index + 1 }}</td>
                                            <td class="text-center align-middle">{{ getCustomerData(branchConfirm.invoice_id, 'sender').name }}</td>
                                            <td class="text-center align-middle">{{ getCustomerData(branchConfirm.invoice_id, 'sender').phone }}</td>
                                            <td class="text-center align-middle">{{ getCustomerData(branchConfirm.invoice_id, 'receiver').name }}</td>
                                            <td class="text-center align-middle">{{ getCustomerData(branchConfirm.invoice_id, 'receiver').phone }}</td>
                                           
                                            <td class="text-center align-middle">{{ branchConfirm.confirm_status === 0 ? 'Not yet arrived' : 'Arrived' }}</td>
                                            <td class="text-center align-middle d-flex gap-3 justify-content-center">
                                                <button v-if="branchConfirm.confirm_status === 0" @click="updateConfirmStatus(branchConfirm.id, 1)" class="btn btn-primary-color">
                                                    Confirm
                                                </button>
                                                <button @click="updateConfirmStatus(branchConfirm.id, 0)" class="btn btn-secondary">
                                                    Cancel
                                                </button>
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
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";

const branchConfirms = ref([]);
const invoices = ref([]);

const fetchBranchConfirm = async () => {
    try {
        $.LoadingOverlay("show");
        const response = await axios.get("http://127.0.0.1:8000/api/branch-confirms");
        branchConfirms.value = response.data;
        $.LoadingOverlay("hide");
    } catch (error) {
        console.error("Error fetching branch confirms:", error);
        $.LoadingOverlay("hide");
    }
};

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

const getCustomerData = (invoiceId, type) => {
    const invoice = invoices.value.find(inv => inv.id === invoiceId);
    if (!invoice) {
        return { name: 'Unknown', phone: 'Phone not available' }; // Replace with appropriate fallback message
    }
    if (type === 'sender' && invoice.sender) {
        return { name: invoice.sender.name, phone: invoice.sender.phone || 'Phone not available' };
    }
    if (type === 'receiver' && invoice.receiver) {
        return { name: invoice.receiver.receiver_name, phone: invoice.receiver.phone || 'Phone not available' };
    }
    return { name: 'Unknown', phone: 'Phone not available' }; // Fallback for unknown cases
};

const getBranchName = (branchId) => {
    if (!branchId) {
        return 'Unknown'; // Handle cases where branchId is null or undefined
    }
    const branch = branches.value.find(branch => branch.id === branchId);
    if (!branch) {
        console.warn(`Branch with ID ${branchId} not found.`);
        return 'Unknown';
    }
    return branch.name;
};

const updateConfirmStatus = async (id, status) => {
    try {
        $.LoadingOverlay("show");
        await axios.put(`http://127.0.0.1:8000/api/branch-confirms/${id}`, {
            confirm_status: status,
        });
        fetchBranchConfirm();
        $.LoadingOverlay("hide");
    } catch (error) {
        console.error("Error updating confirm status:", error);
        $.LoadingOverlay("hide");
    }
};

onMounted(() => {
    fetchBranchConfirm();
    fetchInvoices();
});
</script>

<style></style>
