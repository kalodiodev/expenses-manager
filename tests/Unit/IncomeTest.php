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
        $income = Income::factory()->create();

        $this->assertInstanceOf(User::class, $income->user);
    }

    /** @test */
    public function an_income_belongs_to_a_category()
    {
        $income = Income::factory()->create();

        $this->assertInstanceOf(IncomeCategory::class, $income->category);
    }


    /** @test */
    public function it_finds_incomes_that_contain_given_term()
    {
        Income::factory()->create(['description' => 'Test1']);
        Income::factory()->create(['description' => 'Test2']);

        $incomes = Income::search('Test1');

        $this->assertEquals(1, $incomes->count());
    }
}
