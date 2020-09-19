<?php

namespace Tests\Feature\ExpenseCategory;

use App\ExpenseCategory;
use Tests\IntegrationTestCase;

class ExpenseCategoryDeleteTest extends IntegrationTestCase
{
    protected $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->category = ExpenseCategory::factory()->create();
    }

    /** @test */
    public function a_user_can_ajax_delete_an_expense_category_that_owns()
    {
        $user = $this->signIn();

        $category = ExpenseCategory::factory()->create(['user_id' => $user->id]);

        $this->deleteJson(route('expense.category', ['category' => $category]))
            ->assertNoContent();
    }

    /** @test */
    public function a_user_cannot_delete_an_expense_category_that_belongs_to_other_user()
    {
        $this->signIn();

        $this->deleteJson(route('expense.category', ['category' => $this->category]))
            ->assertNotFound();
    }


    /** @test */
    public function a_guest_cannot_delete_an_expense_categories()
    {
        $this->deleteJson(route('expense.category', ['category' => $this->category]))
            ->assertUnauthorized();
    }
}
