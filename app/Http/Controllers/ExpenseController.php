<?php

namespace App\Http\Controllers;

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
        return auth()->user()
            ->expenses()
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
}
