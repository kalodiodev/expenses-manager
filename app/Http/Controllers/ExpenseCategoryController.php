<?php

namespace App\Http\Controllers;

use App\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ExpenseCategoryController extends Controller
{
    /**
     * Index expense categories
     *
     * @return mixed
     */
    public function index()
    {
        $search = \request()->get('search') ?: '';

        return auth()->user()->expenseCategories()->search($search)->paginate();
    }

    /**
     * Store category
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        return auth()->user()
            ->expenseCategories()
            ->create($request->only(['name', 'description']));
    }

    /**
     * Determine whether category name exists
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function exists(Request $request)
    {
        $category = ExpenseCategory::where('name', $request->name)
            ->where('user_id', auth()->user()->id)
            ->first();

        if ($category) {
            return response()->json([
                'id' => $category->id,
                'exists' => true
            ]);
        }

        return response()->json([
            'id' => null,
            'exists' => false
        ]);
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
        $this->validator($request->all(), $category)->validate();

        $category->update($request->only(['name', 'description']));

        return $category;
    }

    /**
     * Delete Category
     *
     * @param ExpenseCategory $category
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(ExpenseCategory $category)
    {
        if ($category->user->id != auth()->user()->id) {
            abort(404, 'Expense category not found.');
        }

        $category->delete();

        return response()->noContent();
    }

    /**
     * Get a validator for an expense category
     *
     * @param array $data
     * @param null $expense
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $expense = null)
    {
        $rules = [
            'name' => ['required', 'string', 'max:190'],
        ];

        $unique = Rule::unique('expense_categories');
        $rules['name'][] = $expense ? $unique->ignore($expense->id) : $unique;

        return Validator::make($data, $rules);
    }
}
