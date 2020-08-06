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
        return auth()->user()->incomeCategories()->paginate();
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
