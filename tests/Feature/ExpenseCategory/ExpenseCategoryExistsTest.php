<?php

namespace Tests\Feature\ExpenseCategory;

use App\User;
use App\ExpenseCategory;
use Tests\IntegrationTestCase;

class ExpenseCategoryExistsTest extends IntegrationTestCase
{
    /** @test */
    public function an_authenticated_user_can_check_if_category_name_exists()
    {
        $user = $this->signIn();

        $category = factory(ExpenseCategory::class)->create(['user_id' => $user->id]);

        $this->postJson(route('expense.category.exists'), ['name' => $category->name])
            ->assertJson(['exists' => true]);
    }

    /** @test */
    public function other_users_categories_names_not_considered()
    {
        $this->signIn();

        $category = factory(ExpenseCategory::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $this->postJson(route('expense.category.exists'), ['name' => $category->name])
            ->assertJson(['exists' => false]);
    }
}
