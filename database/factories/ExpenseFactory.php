<?php

namespace Database\Factories;

use App\User;
use App\Expense;
use App\ExpenseCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ExpenseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Expense::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'category_id' => ExpenseCategory::factory(),
            'date' => Carbon::now(),
            'description' => $this->faker->sentence,
            'cost' => random_int(1000, 100000) / 100
        ];
    }
}
