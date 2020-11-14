<?php

use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeCategoryController;
use App\Http\Controllers\IncomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/expense-categories', [ExpenseCategoryController::class, 'index'])->name('expense.categories');
    Route::post('/expense-categories', [ExpenseCategoryController::class, 'store']);
    Route::patch('/expense-categories/{category}', [ExpenseCategoryController::class, 'update'])->name('expense.category');
    Route::delete('/expense-categories/{category}', [ExpenseCategoryController::class, 'destroy']);
    Route::post('/expense-categories/exists', [ExpenseCategoryController::class, 'exists'])->name('expense.category.exists');

    Route::get('/income-categories', [IncomeCategoryController::class, 'index'])->name('income.categories');
    Route::post('/income-categories', [IncomeCategoryController::class, 'store']);
    Route::patch('/income-categories/{category}', [IncomeCategoryController::class, 'update'])->name('income.category');
    Route::delete('/income-categories/{category}', [IncomeCategoryController::class, 'destroy']);
    Route::post('/income-categories/exists', [IncomeCategoryController::class, 'exists'])->name('income.category.exists');

    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses');
    Route::post('/expenses', [ExpenseController::class, 'store']);
    Route::patch('/expenses/{expense}', [ExpenseController::class, 'update'])->name('expense');
    Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy']);

    Route::get('/incomes', [IncomeController::class, 'index'])->name('incomes');
    Route::post('/incomes', [IncomeController::class, 'store']);
    Route::patch('/incomes/{income}', [IncomeController::class, 'update'])->name('income');
    Route::delete('/incomes/{income}', [IncomeController::class, 'destroy']);
});
