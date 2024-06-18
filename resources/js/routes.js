import Dashboard from './components/Dashboard.vue'
import BranchList from './pages/branchs/BranchList.vue';
import PaymentMethod from './pages/paymentMethods/PaymentMethod.vue';
import UserList from "./pages/users/UserList.vue";
import Insurance from "./pages/insurances/Insurance.vue";
import Penalty from './pages/penaltys/Penalty.vue';
import Invoice from './pages/invoices/Invoice.vue';
import Customer from './pages/customers/Customer.vue';
import ItemDetail from './pages/itemDetails/ItemDetail.vue';
import BranchConfirm from './pages/branchConfirms/BranchConfirm.vue';
export default [
    {
        path: "/admin/dashboard",
        name: "admin.dashboard",
        component: Dashboard,
    },
    {
        path: "/admin/users",
        name: "admin.users",
        component: UserList,
    },
    {
        path: "/admin/branchs",
        name: "admin.branchs",
        component: BranchList,
    },
    {
        path: "/admin/branch-confirms",
        name: "admin.branch-confirms",
        component: BranchConfirm,
    },
    {
        path: "/admin/paymentMethods",
        name: "admin.paymentMethods",
        component: PaymentMethod,
    },
    {
        path: "/admin/insurances",
        name: "admin.insurances",
        component: Insurance,
    },
    {
        path: "/admin/penaltys",
        name: "admin.penaltys",
        component: Penalty,
    },
    {
        path: "/admin/invoices",
        name: "admin.invoices",
        component: Invoice,
    },
    {
        path: "/admin/customers",
        name: "admin.customers",
        component: Customer,
    },
    {
        path: "/admin/item-details",
        name: "admin.item-details",
        component: ItemDetail,
    },
];