<?php

namespace App\Http\Controllers;

use App\IncomeCategory;
use Illuminate\Http\Request;

class IncomeCategoryController extends Controller
{
    /**
     * Index expense categories
     *
     * @return mixed
     */
    public function index()
    {
        $search = \request()->get('search') ?: '';

        return auth()->user()->incomeCategories()->search($search)->paginate();
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
            ->incomeCategories()
            ->create($request->only(['name', 'description']));
    }

    /**
     * Update Category
     *
     * @param IncomeCategory $category
     * @param Request $request
     * @return IncomeCategory
     */
    public function update(IncomeCategory $category, Request $request)
    {
        $category->update($request->only(['name', 'description']));

        return $category;
    }

    /**
     * Delete Category
     *
     * @param IncomeCategory $category
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(IncomeCategory $category)
    {
        if ($category->user->id != auth()->user()->id) {
            abort(404, 'Income category not found.');
        }

        $category->delete();

        return response()->noContent();
    }
}
