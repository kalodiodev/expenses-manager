<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class StatsController extends Controller
{
    /**
     * Stats
     *
     * @return mixed
     */
    public function index()
    {
        $user = auth()->user();

        return [
            "current_year" => [
                "income" => $user->incomes()->whereBetween('date', [Carbon::now()->startOfYear(), Carbon::now()])->sum('amount'),
                "expenses" => $user->expenses()->whereBetween('date', [Carbon::now()->startOfYear(), Carbon::now()])->sum('cost')
            ],
            "today" => [
                "income" => $user->incomes()->whereBetween('date', [Carbon::now()->startOfDay(), Carbon::now()])->sum('amount'),
                "expenses" => $user->expenses()->whereBetween('date', [Carbon::now()->startOfDay(), Carbon::now()])->sum('cost')
            ],
            "yesterday" => [
                "income" => $user->incomes()->whereBetween('date', [Carbon::yesterday()->startOfDay(), Carbon::yesterday()->endOfDay()])->sum('amount'),
                "expenses" => $user->expenses()->whereBetween('date', [Carbon::yesterday()->startOfDay(), Carbon::yesterday()->endOfDay()])->sum('cost')
            ],
            "current_month" => [
                "income" => $user->incomes()->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()])->sum('amount'),
                "expenses" => $user->expenses()->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()])->sum('cost')
            ],
            "last_month" => [
                "income" => $user->incomes()->whereBetween('date', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])->sum('amount'),
                "expenses" => $user->expenses()->whereBetween('date', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])->sum('cost')
            ],
            "last_year" => [
                "income" => $user->incomes()->whereBetween('date', [Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear()])->sum('amount'),
                "expenses" => $user->expenses()->whereBetween('date', [Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear()])->sum('cost')
            ]
        ];
    }
}
