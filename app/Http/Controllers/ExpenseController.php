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
        return auth()->user()->expenses()->paginate();
    }
}
