<?php

namespace App\Http\Controllers;

use App\Income;
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

        $incomes = auth()->user()->incomes();

        if (request()->has('category')) {
            $incomes->where('category_id', request()->get('category'));
        }

        return $incomes
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

    /**
     * Delete Income
     *
     * @param Income $income
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Income $income)
    {
        if ($income->user->id != auth()->user()->id) {
            abort(404, 'Income not found.');
        }

        $income->delete();

        return response()->noContent();
    }
}
