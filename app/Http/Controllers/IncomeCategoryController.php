<?php

namespace App\Http\Controllers;

use App\IncomeCategory;
use Illuminate\Http\Request;

class IncomeCategoryController extends Controller
{
    /**
     * Index expense categories
     *
     * @return mixed
     */
    public function index()
    {
        return auth()->user()->incomeCategories()->paginate();
    }
}
