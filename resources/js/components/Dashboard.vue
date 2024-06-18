<template>
    <div class="container">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ dashboardData.invoices_count }}</h3>
                                <p>Invioces Records</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer"
                                >More info
                                <i class="fas fa-arrow-circle-right"></i
                            ></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ dashboardData.users_count }}</h3>
                                <p>Admin</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer"
                                >More info
                                <i class="fas fa-arrow-circle-right"></i
                            ></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ dashboardData.customers_count }}</h3>
                                <p>Customer Records</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer"
                                >More info
                                <i class="fas fa-arrow-circle-right"></i
                            ></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ dashboardData.branchs_count }}</h3>
                                <p>Branch Record</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer"
                                >More info
                                <i class="fas fa-arrow-circle-right"></i
                            ></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <div class="row">
                    <section class="col-12 connectedSortable">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ion ion-clipboard mr-1"></i>
                                    To Do List
                                </h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm">
                                        <li class="page-item">
                                            <a href="#" class="page-link"
                                                >&laquo;</a
                                            >
                                        </li>
                                        <li class="page-item">
                                            <a href="#" class="page-link">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="#" class="page-link">2</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="#" class="page-link">3</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="#" class="page-link"
                                                >&raquo;</a
                                            >
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="todo-list" data-widget="todo-list">
                                    <li
                                        v-for="(todo, index) in todoList"
                                        :key="index"
                                    >
                                        <span class="handle">
                                            <i class="fas fa-ellipsis-v"></i>
                                            <i class="fas fa-ellipsis-v"></i>
                                        </span>
                                        <div
                                            class="icheck-primary d-inline ml-2"
                                        >
                                            <input
                                                type="checkbox"
                                                :id="'todoCheck' + index"
                                                :checked="todo.completed"
                                            />
                                            <label
                                                :for="'todoCheck' + index"
                                            ></label>
                                        </div>
                                        <span class="text">{{
                                            todo.task
                                        }}</span>
                                        <small
                                            class="badge badge-{{ todo.label }}"
                                            ><i class="far fa-clock"></i>
                                            {{ todo.time }}</small
                                        >
                                        <div class="tools">
                                            <i class="fas fa-edit"></i>
                                            <i class="fas fa-trash-o"></i>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <button
                                    type="button"
                                    class="btn btn-primary-color float-right"
                                >
                                    <i class="fas fa-plus"></i> Add item
                                </button>
                            </div>
                        </div>
                    </section>
                    <!-- /.Left col -->
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";

const dashboardData = ref({
    invoices_count: 0,
    users_count: 0,
    customers_count: 0,
    branchs_count: 0,
});

const todoList = ref([
    {
        task: "Design a nice theme",
        completed: false,
        label: "danger",
        time: "2 mins",
    },
    {
        task: "Make the theme responsive",
        completed: true,
        label: "info",
        time: "4 hours",
    },
    {
        task: "Let theme shine like a star",
        completed: false,
        label: "warning",
        time: "1 day",
    },
    {
        task: "Check your messages and notifications",
        completed: false,
        label: "primary",
        time: "1 week",
    },
    {
        task: "Let theme shine like a star",
        completed: false,
        label: "secondary",
        time: "1 month",
    },
]);

const fetchDashboardData = async () => {
    try {
        const response = await axios.get(
            "http://127.0.0.1:8000/api/dashboards"
        );
        dashboardData.value = response.data;
    } catch (error) {
        console.error("Error fetching dashboard data:", error);
    }
};

onMounted(() => {
    fetchDashboardData();
});
</script>

<style></style>
