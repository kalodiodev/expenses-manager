<?php

namespace Database\Factories;

use App\Income;
use App\User;
use App\IncomeCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class IncomeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Income::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'category_id' => IncomeCategory::factory(),
            'date' => Carbon::now(),
            'description' => $this->faker->sentence,
            'amount' => random_int(1000, 100000) / 100
        ];
    }
}
