<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\ExpenseCategory;
use Faker\Generator as Faker;

$factory->define(ExpenseCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'user_id' => factory(User::class),
    ];
});
