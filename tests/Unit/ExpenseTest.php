<?php

namespace Tests\Unit;

use App\User;
use App\Expense;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_expense_belongs_to_a_user()
    {
        $expense = factory(Expense::class)->create();

        $this->assertInstanceOf(User::class, $expense->user);
    }
}
