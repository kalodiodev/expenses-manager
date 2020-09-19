<?php

namespace Tests\Feature\Expense;

use App\User;
use App\Expense;
use Tests\IntegrationTestCase;

class ExpenseIndexTest extends IntegrationTestCase
{
    /** @test */
    public function an_authenticated_user_can_index_own_expenses_json()
    {
        $user = $this->signIn();

        Expense::factory()->create(['user_id' => $user->id]);

        $this->getJson(route('expenses'))
            ->assertJsonCount(1, 'data');
    }

    /** @test */
    public function an_authenticated_user_cannot_index_others_expenses()
    {
        $this->signIn();

        Expense::factory()->create([
            'user_id' => User::factory()->create()
        ]);

        $this->getJson(route('expenses'))
            ->assertJsonCount(0, 'data');
    }

    /** @test */
    public function a_guest_cannot_index_expenses()
    {
        $this->getJson(route('expenses'))
            ->assertUnauthorized();
    }

    /** @test */
    public function a_user_can_search_expenses()
    {
        $user = $this->signIn();

        Expense::factory()->create([
            'user_id' => $user->id,
            'description' => 'Test'
        ]);

        Expense::factory()->create([
            'user_id' => $user->id,
            'description' => 'Other'
        ]);

        $this->getJson(route('expenses', ['search' => 'Test']))
            ->assertJsonCount(1, 'data');
    }
}
