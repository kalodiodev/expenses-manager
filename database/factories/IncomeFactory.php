<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Income;
use App\IncomeCategory;
use Faker\Generator as Faker;

$factory->define(Income::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'category_id' => factory(IncomeCategory::class),
        'date' => \Carbon\Carbon::now(),
        'description' => $faker->sentence,
        'amount' => random_int(1000, 100000) / 100
    ];
});
