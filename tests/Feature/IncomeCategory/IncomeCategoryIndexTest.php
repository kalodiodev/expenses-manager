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

        factory(IncomeCategory::class)->create(['user_id' => $user->id]);

        $this->get(route('income.categories'), ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
            ->assertJsonCount(1, 'data');
    }

    /** @test */
    public function an_authenticated_user_cannot_index_others_income_categories()
    {
        $this->signIn();

        factory(IncomeCategory::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $this->get(route('income.categories'), ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
            ->assertJsonCount(0, 'data');
    }
}
