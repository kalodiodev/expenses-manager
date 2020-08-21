<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Expense;
use App\User;
use Faker\Generator as Faker;

$factory->define(Expense::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'date' => $faker->dateTime,
        'description' => $faker->sentence,
        'cost' => random_int(1000, 100000) / 100
    ];
});
