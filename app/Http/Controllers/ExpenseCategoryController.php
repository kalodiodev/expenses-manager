<?php

namespace App\Http\Controllers;

use App\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    /**
     * Index expense categories
     *
     * @return mixed
     */
    public function index()
    {
        return auth()->user()->expenseCategories()->paginate();
    }

    /**
     * Store category
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        return auth()->user()
            ->expenseCategories()
            ->create($request->only(['name', 'description']));
    }

    /**
     * Update Category
     *
     * @param ExpenseCategory $category
     * @param Request $request
     * @return ExpenseCategory
     */
    public function update(ExpenseCategory $category, Request $request)
    {
        $category->update($request->only(['name', 'description']));

        return $category;
    }
}
