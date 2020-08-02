import Vue from 'vue'
import VueRouter from 'vue-router'
import ExpenseCategories from '../components/ExpenseCategoriesComponent'
import Expenses from '../components/ExpensesComponent'
import DashboardComponent from "../components/DashboardComponent";

Vue.use(VueRouter)

const routes = [
    { path: '', component: DashboardComponent, name: 'dashboard'},
    { path: '/expense-categories', component: ExpenseCategories,  name: 'expense-categories'},
    { path: '/expenses', component: Expenses, name: 'expenses'}
];

const router = new VueRouter({mode: 'hash', routes})

export default router
