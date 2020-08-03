<?php

namespace Tests\Feature\ExpenseCategory;

use App\User;
use App\ExpenseCategory;
use Tests\IntegrationTestCase;

class ExpenseCategoryIndexTest extends IntegrationTestCase
{
    /** @test */
    public function an_authenticated_user_can_index_own_categories_json()
    {
        $user = $this->signIn();

        factory(ExpenseCategory::class)->create(['user_id' => $user->id]);

        $this->get(route('expense.categories'), ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
            ->assertJsonCount(1, 'data');
    }

    /** @test */
    public function an_authenticated_user_cannot_index_others_categories()
    {
        $this->signIn();

        factory(ExpenseCategory::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $this->get(route('expense.categories'), ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
            ->assertJsonCount(0, 'data');
    }

    /** @test */
    public function a_user_can_search_categories()
    {
        $user = $this->signIn();

        factory(ExpenseCategory::class)->create([
            'user_id' => $user->id,
            'name' => 'Test'
        ]);

        factory(ExpenseCategory::class)->create([
            'user_id' => $user->id,
            'name' => 'Other'
        ]);

        $this->getJson(route('expense.categories', ['search' => 'Test']))
            ->assertJsonCount(1, 'data');
    }
}
