<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use App\IncomeCategory;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IncomeCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_income_category_belongs_to_a_user()
    {
        $category = IncomeCategory::factory()->create();

        $this->assertInstanceOf(User::class, $category->user);
    }

    /** @test */
    public function an_income_category_has_incomes()
    {
        $category = IncomeCategory::factory()->create();

        $this->assertInstanceOf(Collection::class, $category->incomes);
    }

    /** @test */
    public function it_finds_categories_that_contain_given_term()
    {
        IncomeCategory::factory()->create(['name' => 'Test1']);
        IncomeCategory::factory()->create(['name' => 'Test2']);

        $categories = IncomeCategory::search('Test1');

        $this->assertEquals(1, $categories->count());
    }
}
