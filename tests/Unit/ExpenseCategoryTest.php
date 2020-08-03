<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use App\ExpenseCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExpenseCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_expense_category_belongs_to_a_user()
    {
        $category = factory(ExpenseCategory::class)->create();

        $this->assertInstanceOf(User::class, $category->user);
    }

    /** @test */
    public function it_finds_categories_that_contain_given_term()
    {
        factory(ExpenseCategory::class)->create(['name' => 'Test1']);
        factory(ExpenseCategory::class)->create(['name' => 'Test2']);

        $categories = ExpenseCategory::search('Test1');

        $this->assertEquals(1, $categories->count());
    }
}
