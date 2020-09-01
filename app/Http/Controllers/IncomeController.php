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
        return auth()->user()
            ->incomes()
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(20);
    }
}
