<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Http\Request;

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
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        return auth()->user()
            ->expenses()
            ->create($request->only(['date', 'description', 'cost']));
    }

    /**
     * Update Expense
     *
     * @param Expense $expense
     * @param Request $request
     * @return Expense
     */
    public function update(Expense $expense, Request $request)
    {
        if ($expense->user->id != auth()->user()->id) {
            abort(404, 'Expense not found.');
        }

        $expense->update($request->only(['date', 'description', 'cost']));

        return $expense;
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
