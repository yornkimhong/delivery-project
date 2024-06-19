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
                                <h3 class="card-title">customers List</h3>
                            </div>
                            <div class="card-body">
                                <!-- customers Table -->
                                <table
                                    id="example1"
                                    class="table table-bordered table-striped"
                                >
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Sender Name</th>
                                            <th class="text-center">Receiver Phone</th>
                                            <th class="text-center">
                                                Receiver Name
                                            </th>
                                            <th class="text-center">
                                                Receiver Phone
                                            </th>
                                            <th class="text-center">
                                                Curent Address
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(
                                                customer, index
                                            ) in customers"
                                            :key="customer.id"
                                        >
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ index + 1 }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ customer.name }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ customer.phone }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ customer.receiver_name }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ customer.receiver_phone }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ customer.current_address }}
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
import { ref, onMounted} from "vue";
const customers = ref([]);

const fetchCustomer = async () => {
    try {
        $.LoadingOverlay("show");
        const response = await axios.get("http://127.0.0.1:8000/api/customers");
        customers.value = response.data;
        $.LoadingOverlay("hide");
    } catch (error) {
        console.error("Error fetching customers:", error);
        $.LoadingOverlay("hide");
    }
};

onMounted(() => {
    fetchCustomer();
});
</script>

<style></style>
