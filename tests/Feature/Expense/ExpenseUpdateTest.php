<?php

namespace Tests\Feature\Expense;

use App\Expense;
use Illuminate\Support\Str;
use Tests\IntegrationTestCase;

class ExpenseUpdateTest extends IntegrationTestCase
{
    protected $expense;

    public function setUp(): void
    {
        parent::setUp();

        $this->expense = factory(Expense::class)->create();
    }

    /** @test */
    public function a_user_can_ajax_patch_an_expense_that_owns()
    {
        $user = $this->signIn();

        $expense = factory(Expense::class)->create(['user_id' => $user->id]);

        $this->patchJson(route('expense', ['expense' => $expense->id]), $new = factory(Expense::class)->raw())
            ->assertOk();

        $this->assertEquals($new['description'], $expense->fresh()->description);
        $this->assertEquals($new['cost'], $expense->fresh()->cost);
    }

    /** @test */
    public function a_user_cannot_patch_an_expense_that_belongs_to_other_user()
    {
        $this->signIn();

        $this->patchJson(route('expense', ['expense' => $this->expense->id]), $new = factory(Expense::class)->raw())
            ->assertNotFound();
    }

    /** @test */
    public function a_guest_cannot_patch_an_expense()
    {
        $this->patchJson(route('expense', ['expense' => $this->expense->id]), $new = factory(Expense::class)->raw())
            ->assertUnauthorized();
    }

    /** @test */
    public function an_expense_requires_a_valid_date()
    {
        $this->signIn();

        $this->patchJson(route('expense', ['expense' => $this->expense->id]), factory(Expense::class)->raw(['date' => '']))
            ->assertJsonValidationErrors('date');

        $this->patchJson(route('expense', ['expense' => $this->expense->id]), factory(Expense::class)->raw(['date' => 'string']))
            ->assertJsonValidationErrors('date');
    }

    /** @test */
    public function an_expense_requires_a_valid_cost()
    {
        $this->signIn();

        $this->patchJson(route('expense', ['expense' => $this->expense->id]), factory(Expense::class)->raw(['cost' => '']))
            ->assertJsonValidationErrors('cost');

        $this->patchJson(route('expense', ['expense' => $this->expense->id]), factory(Expense::class)->raw(['cost' => 'string']))
            ->assertJsonValidationErrors('cost');

        $this->patchJson(route('expense', ['expense' => $this->expense->id]), factory(Expense::class)->raw(['cost' => -10]))
            ->assertJsonValidationErrors('cost');
    }

    /** @test */
    public function an_expense_description_has_a_max_length()
    {
        $this->signIn();

        $this->patchJson(route('expense', ['expense' => $this->expense->id]), factory(Expense::class)->raw(['description' => Str::random(191)]))
            ->assertJsonValidationErrors('description');
    }
}
