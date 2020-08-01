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
        $categories = auth()->user()->expenseCategories()->paginate();

        if (\request()->ajax()) {
            return $categories;
        }

        return view('expense-category.index')->with([
            'categories' => $categories
        ]);
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
