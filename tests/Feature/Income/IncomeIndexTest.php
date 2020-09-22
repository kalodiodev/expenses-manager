<?php

namespace Tests\Feature\Income;

use App\IncomeCategory;
use App\User;
use App\Income;
use Tests\IntegrationTestCase;

class IncomeIndexTest extends IntegrationTestCase
{
    /** @test */
    public function an_authenticated_user_can_index_own_incomes_json()
    {
        $user = $this->signIn();

        Income::factory()->create(['user_id' => $user->id]);

        $this->getJson(route('incomes'))
            ->assertJsonCount(1, 'data');
    }

    /** @test */
    public function an_authenticated_user_cannot_index_others_incomes()
    {
        $this->signIn();

        Income::factory()->create([
            'user_id' => User::factory()->create()
        ]);

        $this->getJson(route('incomes'))
            ->assertJsonCount(0, 'data');
    }

    /** @test */
    public function a_guest_cannot_index_incomes()
    {
        $this->getJson(route('incomes'))
            ->assertUnauthorized();
    }

    /** @test */
    public function a_user_can_search_incomes()
    {
        $user = $this->signIn();

        Income::factory()->create([
            'user_id' => $user->id,
            'description' => 'Test'
        ]);

        Income::factory()->create([
            'user_id' => $user->id,
            'description' => 'Other'
        ]);

        $this->getJson(route('incomes', ['search' => 'Test']))
            ->assertJsonCount(1, 'data');
    }

    /** @test */
    public function a_user_can_filter_incomes_by_category()
    {
        $user = $this->signIn();

        $salary = IncomeCategory::factory()
            ->hasIncomes(2, ['user_id' => $user->id])
            ->create(['user_id' => $user->id]);

        IncomeCategory::factory()
            ->hasIncomes(3, ['user_id' => $user->id])
            ->create(['user_id' => $user->id]);

        $this->getJson(route('incomes', ['category' => $salary->id, 'nopagination' => 1]))
            ->assertJsonCount(2, 'data');
    }
}
