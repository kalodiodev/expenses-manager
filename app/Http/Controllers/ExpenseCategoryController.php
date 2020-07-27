<?php

namespace App\Http\Controllers;

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
        $categories = auth()->user()->expenseCategories()->paginate();

        if (\request()->ajax()) {
            return $categories;
        }

        return view('expense-category.index')->with([
            'categories' => $categories
        ]);
    }
}
