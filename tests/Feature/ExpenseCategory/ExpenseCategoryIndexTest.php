<?php

namespace Tests\Feature\ExpenseCategory;

use App\User;
use Tests\TestCase;
use App\ExpenseCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExpenseCategoryIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_index_own_categories_json()
    {
        $this->actingAs($user = factory(User::class)->create());

        factory(ExpenseCategory::class)->create(['user_id' => $user->id]);

        $this->get(route('expense.categories'), ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
            ->assertJsonCount(1, 'data');
    }

    /** @test */
    public function an_authenticated_user_cannot_index_others_categories()
    {
        $this->actingAs(factory(User::class)->create());

        factory(ExpenseCategory::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $this->get(route('expense.categories'), ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
            ->assertJsonCount(0, 'data');
    }
}
