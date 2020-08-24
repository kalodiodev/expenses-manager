<?php

namespace Tests\Feature\Expense;

use App\Expense;
use Illuminate\Support\Str;
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

    /** @test */
    public function an_expense_requires_a_valid_date()
    {
        $this->signIn();

        $this->postJson(route('expenses'), factory(Expense::class)->raw(['date' => '']))
            ->assertJsonValidationErrors('date');

        $this->postJson(route('expenses'), factory(Expense::class)->raw(['date' => 'string']))
            ->assertJsonValidationErrors('date');
    }

    /** @test */
    public function an_expense_requires_a_valid_cost()
    {
        $this->signIn();

        $this->postJson(route('expenses'), factory(Expense::class)->raw(['cost' => '']))
            ->assertJsonValidationErrors('cost');

        $this->postJson(route('expenses'), factory(Expense::class)->raw(['cost' => 'string']))
            ->assertJsonValidationErrors('cost');

        $this->postJson(route('expenses'), factory(Expense::class)->raw(['cost' => -10]))
            ->assertJsonValidationErrors('cost');
    }

    /** @test */
    public function an_expense_description_has_a_max_length()
    {
        $this->signIn();

        $this->postJson(route('expenses'), factory(Expense::class)->raw(['description' => Str::random(191)]))
            ->assertJsonValidationErrors('description');
    }
}
