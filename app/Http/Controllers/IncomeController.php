<?php

namespace App\Http\Controllers;

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
}
