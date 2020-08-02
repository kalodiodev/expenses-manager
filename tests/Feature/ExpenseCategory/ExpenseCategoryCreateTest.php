<?php

namespace Tests\Feature\ExpenseCategory;

use App\ExpenseCategory;
use Tests\IntegrationTestCase;

class ExpenseCategoryCreateTest extends IntegrationTestCase
{
    /** @test */
    public function a_user_can_ajax_post_an_expense_category()
    {
        $this->signIn();

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
