<?php

namespace Tests\Feature\ExpenseCategory;

use App\User;
use Tests\TestCase;
use App\ExpenseCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExpenseCategoryUpdateTest extends TestCase
{
    use RefreshDatabase;

    protected $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->category = factory(ExpenseCategory::class)->create();
    }

    /** @test */
    public function a_user_can_ajax_patch_an_expense_category()
    {
        $this->actingAs(factory(User::class)->create());

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
