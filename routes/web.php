<?php

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
    Route::get('/expense-categories', 'ExpenseCategoryController@index')->name('expense.categories');
    Route::post('/expense-categories', 'ExpenseCategoryController@store');
    Route::patch('/expense-categories/{category}', 'ExpenseCategoryController@update')->name('expense.category');
    Route::delete('/expense-categories/{category}', 'ExpenseCategoryController@destroy');

    Route::get('/income-categories', 'IncomeCategoryController@index')->name('income.categories');
    Route::post('/income-categories', 'IncomeCategoryController@store');
    Route::delete('/income-categories/{category}', 'IncomeCategoryController@destroy')->name('income.category');
});
