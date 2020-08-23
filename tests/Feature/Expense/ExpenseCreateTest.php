<?php

namespace Tests\Feature\Expense;

use App\Expense;
use Tests\IntegrationTestCase;

class ExpenseCreateTest extends IntegrationTestCase
{
    /** @test */
    public function a_user_can_ajax_post_an_expense()
    {
        $this->signIn();

        $this->postJson(route('expenses'), factory(Expense::class)->raw())
            ->assertCreated();
    }

    /** @test */
    public function a_guest_cannot_post_an_expense()
    {
        $this->postJson(route('expenses'), factory(Expense::class)->raw())
            ->assertUnauthorized();
    }
}
