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
}
