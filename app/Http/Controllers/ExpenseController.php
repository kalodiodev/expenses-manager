<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Http\Requests\ExpenseRequest;

class ExpenseController extends Controller
{
    /**
     * Index Expenses
     *
     * @return mixed
     */
    public function index()
    {
        $search = \request()->get('search') ?: '';

        return auth()->user()
            ->expenses()
            ->search($search)
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(20);
    }

    /**
     * Store Expense
     *
     * @param ExpenseRequest $request
     * @return mixed
     */
    public function store(ExpenseRequest $request)
    {
        return auth()->user()
            ->expenses()
            ->create($request->only(['category_id', 'date', 'description', 'cost']));
    }

    /**
     * Update Expense
     *
     * @param Expense $expense
     * @param ExpenseRequest $request
     * @return Expense
     */
    public function update(Expense $expense, ExpenseRequest $request)
    {
        if ($expense->user->id != auth()->user()->id) {
            abort(404, 'Expense not found.');
        }

        $expense->update($request->only(['category_id', 'date', 'description', 'cost']));

        return $expense->fresh();
    }

    /**
     * Delete Expense
     *
     * @param Expense $expense
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Expense $expense)
    {
        if ($expense->user->id != auth()->user()->id) {
            abort(404, 'Expense not found.');
        }

        $expense->delete();

        return response()->noContent();
    }
}
