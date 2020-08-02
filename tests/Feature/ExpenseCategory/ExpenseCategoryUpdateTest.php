<?php

namespace Tests\Feature\ExpenseCategory;

use App\ExpenseCategory;
use Tests\IntegrationTestCase;

class ExpenseCategoryUpdateTest extends IntegrationTestCase
{
    protected $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->category = factory(ExpenseCategory::class)->create();
    }

    /** @test */
    public function a_user_can_ajax_patch_an_expense_category()
    {
        $this->signIn();

        $this->patchJson(route('expense.category', ['category' => $this->category]), factory(ExpenseCategory::class)->raw())
            ->assertOk();
    }

    /** @test */
    public function a_guest_cannot_patch_an_expense_categories()
    {
        $this->patchJson(route('expense.category', ['category' => $this->category]), factory(ExpenseCategory::class)->raw())
            ->assertUnauthorized();
    }
}
