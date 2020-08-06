<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use App\IncomeCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IncomeCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_expense_category_belongs_to_a_user()
    {
        $category = factory(IncomeCategory::class)->create();

        $this->assertInstanceOf(User::class, $category->user);
    }

    /** @test */
    public function it_finds_categories_that_contain_given_term()
    {
        factory(IncomeCategory::class)->create(['name' => 'Test1']);
        factory(IncomeCategory::class)->create(['name' => 'Test2']);

        $categories = IncomeCategory::search('Test1');

        $this->assertEquals(1, $categories->count());
    }
}
