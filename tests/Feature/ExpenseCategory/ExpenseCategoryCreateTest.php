<?php

namespace Tests\Feature\ExpenseCategory;

use App\ExpenseCategory;
use Illuminate\Support\Str;
use Tests\IntegrationTestCase;

class ExpenseCategoryCreateTest extends IntegrationTestCase
{
    /** @test */
    public function a_user_can_ajax_post_an_expense_category()
    {
        $this->signIn();

        $this->postJson(route('expense.categories'), ExpenseCategory::factory()->raw())
            ->assertCreated();
    }

    /** @test */
    public function a_guest_cannot_post_an_expense_categories()
    {
        $this->postJson(route('expense.categories'), ExpenseCategory::factory()->raw())
            ->assertUnauthorized();
    }

    /** @test */
    public function an_expense_category_requires_a_name()
    {
        $this->signIn();

        $this->postJson(route('expense.categories'), ExpenseCategory::factory()->raw(['name' => '']))
            ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function expense_category_name_has_a_max_length()
    {
        $this->signIn();

        $this->postJson(route('expense.categories'), ExpenseCategory::factory()->raw(['name' => Str::random(191)]))
            ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function expense_category_name_must_be_unique()
    {
        $this->signIn();

        ExpenseCategory::factory()->create(['name' => 'test']);

        $this->postJson(route('expense.categories'), ExpenseCategory::factory()->raw(['name' => 'test']))
            ->assertJsonValidationErrors('name');
    }
}
