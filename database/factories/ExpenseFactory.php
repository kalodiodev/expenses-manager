<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Expense;
use App\ExpenseCategory;
use Faker\Generator as Faker;

$factory->define(Expense::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'category_id' => factory(ExpenseCategory::class),
        'date' => \Carbon\Carbon::now(),
        'description' => $faker->sentence,
        'cost' => random_int(1000, 100000) / 100
    ];
});
