<?php

namespace App\Http\Controllers;

use App\IncomeCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

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
        $this->validator($request->all())->validate();

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
        $this->validator($request->all(), $category)->validate();

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

    /**
     * Determine whether category name exists
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function exists(Request $request)
    {
        $category = IncomeCategory::where('name', $request->name)
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
     * Get a validator for an income category
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

        $unique = Rule::unique('income_categories');
        $rules['name'][] = $expense ? $unique->ignore($expense->id) : $unique;

        return Validator::make($data, $rules);
    }
}
