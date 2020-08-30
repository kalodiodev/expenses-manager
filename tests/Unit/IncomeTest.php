<?php

namespace Tests\Unit;

use App\User;
use App\Income;
use Tests\TestCase;
use App\IncomeCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IncomeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_income_belongs_to_a_user()
    {
        $income = factory(Income::class)->create();

        $this->assertInstanceOf(User::class, $income->user);
    }

    /** @test */
    public function an_income_belongs_to_a_category()
    {
        $income = factory(Income::class)->create();

        $this->assertInstanceOf(IncomeCategory::class, $income->category);
    }
}
