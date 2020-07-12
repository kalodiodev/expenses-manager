<?php

namespace Tests\Feature\ExpenseCategory;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExpenseCategoryIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_index_expense_categories()
    {
        $this->actingAs(factory(User::class)->create());

        $this->get(route('expense.categories'))
            ->assertViewIs('expense-category.index')
            ->assertViewHas('categories');
    }

    /** @test */
    public function a_guest_cannot_index_expense_categories()
    {
        $this->get(route('expense.categories'))
            ->assertRedirect(route('login'));
    }
}
