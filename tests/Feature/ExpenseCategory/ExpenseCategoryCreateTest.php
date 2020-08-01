<?php

namespace Tests\Feature\ExpenseCategory;

use App\User;
use Tests\TestCase;
use App\ExpenseCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExpenseCategoryCreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_ajax_post_an_expense_category()
    {
        $this->actingAs(factory(User::class)->create());

        $this->postJson(route('expense.categories'), factory(ExpenseCategory::class)->raw())
            ->assertCreated();
    }

    /** @test */
    public function a_guest_cannot_post_an_expense_categories()
    {
        $this->postJson(route('expense.categories'), factory(ExpenseCategory::class)->raw())
            ->assertUnauthorized();
    }
}
