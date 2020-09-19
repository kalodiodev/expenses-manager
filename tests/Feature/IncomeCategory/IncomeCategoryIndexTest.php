<?php

namespace Tests\Feature\IncomeCategory;

use App\User;
use App\IncomeCategory;
use Tests\IntegrationTestCase;

class IncomeCategoryIndexTest extends IntegrationTestCase
{
    /** @test */
    public function an_authenticated_user_can_index_own_income_categories_json()
    {
        $user = $this->signIn();

        IncomeCategory::factory()->create(['user_id' => $user->id]);

        $this->get(route('income.categories'), ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
            ->assertJsonCount(1, 'data');
    }

    /** @test */
    public function an_authenticated_user_cannot_index_others_income_categories()
    {
        $this->signIn();

        IncomeCategory::factory()->create([
            'user_id' => User::factory()->create()
        ]);

        $this->get(route('income.categories'), ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
            ->assertJsonCount(0, 'data');
    }

    /** @test */
    public function a_user_can_search_income_categories()
    {
        $user = $this->signIn();

        IncomeCategory::factory()->create([
            'user_id' => $user->id,
            'name' => 'Test'
        ]);

        IncomeCategory::factory()->create([
            'user_id' => $user->id,
            'name' => 'Other'
        ]);

        $this->getJson(route('income.categories', ['search' => 'Test']))
            ->assertJsonCount(1, 'data');
    }

    /** @test */
    public function a_user_can_index_income_categories_with_no_pagination()
    {
        $user = $this->signIn();

        IncomeCategory::factory()->count(50)->create(['user_id' => $user->id]);

        $this->getJson(route('income.categories', ['nopagination']))
            ->assertJsonCount(50);
    }
}
