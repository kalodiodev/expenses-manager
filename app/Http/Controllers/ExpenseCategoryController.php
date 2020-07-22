<?php

namespace App\Http\Controllers;

use App\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    /**
     * Index expense categories
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (\request()->ajax()) {
            return ExpenseCategory::paginate(10);
        }

        return view('expense-category.index')->with([
            'categories' => ExpenseCategory::paginate(20)
        ]);
    }
}
