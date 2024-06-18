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
                                <h3 class="card-title">itemDetails List</h3>
                            </div>
                            <div class="card-body">
                                <!-- itemDetails Table -->
                                <table
                                    id="example1"
                                    class="table table-bordered table-striped"
                                >
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">
                                                Description
                                            </th>
                                            <th class="text-center">
                                                Quantity
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(
                                                itemDetail, index
                                            ) in itemDetails"
                                            :key="itemDetail.id"
                                        >
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ index + 1 }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ itemDetail.description }}
                                            </td>
                                            <td
                                                class="text-center align-middle"
                                            >
                                                {{ itemDetail.quantity }}
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
const itemDetails = ref([]);

const fetchItemDetail = async () => {
    try {
        $.LoadingOverlay("show");
        const response = await axios.get(
            "http://127.0.0.1:8000/api/item-details"
        );
        itemDetails.value = response.data;
        $.LoadingOverlay("hide");
    } catch (error) {
        console.error("Error fetching itemDetails:", error);
        $.LoadingOverlay("hide");
    }
};

onMounted(() => {
    fetchItemDetail();
});
</script>

<style></style>
