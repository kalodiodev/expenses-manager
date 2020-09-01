<?php

namespace Tests\Feature\Income;

use App\User;
use App\Income;
use Tests\IntegrationTestCase;

class IncomeIndexTest extends IntegrationTestCase
{
    /** @test */
    public function an_authenticated_user_can_index_own_incomes_json()
    {
        $user = $this->signIn();

        factory(Income::class)->create(['user_id' => $user->id]);

        $this->getJson(route('incomes'))
            ->assertJsonCount(1, 'data');
    }

    /** @test */
    public function an_authenticated_user_cannot_index_others_incomes()
    {
        $this->signIn();

        factory(Income::class)->create([
            'user_id' => factory(User::class)->create()->id
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
}
