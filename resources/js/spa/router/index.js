import Vue from 'vue'
import VueRouter from 'vue-router'
import ExpenseCategories from '../components/ExpenseCategoriesComponent'
import IncomeCategories from '../components/IncomeCategoriesComponent'
import Expenses from '../components/ExpensesComponent'
import DashboardComponent from "../components/DashboardComponent";

Vue.use(VueRouter)

const routes = [
    { path: '', component: DashboardComponent, name: 'dashboard'},
    { path: '/expense-categories', component: ExpenseCategories,  name: 'expense-categories'},
    { path: '/expenses', component: Expenses, name: 'expenses'},
    { path: '/income-categories', component: IncomeCategories,  name: 'income-categories'},
];

const router = new VueRouter({mode: 'hash', routes})

export default router
