<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomeRequest;

class IncomeController extends Controller
{
    /**
     * Index incomes
     *
     * @return mixed
     */
    public function index()
    {
        $search = \request()->get('search') ?: '';

        return auth()->user()
            ->incomes()
            ->search($search)
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(20);
    }

    /**
     * Store Income
     *
     * @param IncomeRequest $request
     * @return mixed
     */
    public function store(IncomeRequest $request)
    {
        return auth()->user()
            ->incomes()
            ->create($request->only(['category_id', 'date', 'description', 'amount']));
    }
}
