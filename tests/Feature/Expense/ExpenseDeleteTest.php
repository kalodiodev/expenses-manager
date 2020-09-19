<?php

namespace Tests\Feature\Expense;

use App\Expense;
use Tests\IntegrationTestCase;

class ExpenseDeleteTest extends IntegrationTestCase
{
    protected $expense;

    public function setUp(): void
    {
        parent::setUp();

        $this->expense = Expense::factory()->create();
    }

    /** @test */
    public function a_user_can_ajax_delete_an_expense_that_owns()
    {
        $user = $this->signIn();

        $expense = Expense::factory()->create(['user_id' => $user->id]);

        $this->deleteJson(route('expense', ['expense' => $expense]))
            ->assertNoContent();
    }

    /** @test */
    public function a_user_cannot_delete_an_expense_that_belongs_to_other_user()
    {
        $this->signIn();

        $this->deleteJson(route('expense', ['expense' => $this->expense]))
            ->assertNotFound();
    }


    /** @test */
    public function a_guest_cannot_delete_an_expense()
    {
        $this->deleteJson(route('expense', ['expense' => $this->expense]))
            ->assertUnauthorized();
    }
}
