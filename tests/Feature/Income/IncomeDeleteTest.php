<?php

namespace Tests\Feature\Income;

use App\Income;
use Tests\IntegrationTestCase;

class IncomeDeleteTest extends IntegrationTestCase
{
    protected $income;

    public function setUp(): void
    {
        parent::setUp();

        $this->income = factory(Income::class)->create();
    }

    /** @test */
    public function a_user_can_ajax_delete_an_income_that_owns()
    {
        $user = $this->signIn();

        $income = factory(Income::class)->create(['user_id' => $user->id]);

        $this->deleteJson(route('income', ['income' => $income]))
            ->assertNoContent();
    }

    /** @test */
    public function a_user_cannot_delete_an_income_that_belongs_to_other_user()
    {
        $this->signIn();

        $this->deleteJson(route('income', ['income' => $this->income]))
            ->assertNotFound();
    }


    /** @test */
    public function a_guest_cannot_delete_an_income()
    {
        $this->deleteJson(route('income', ['income' => $this->income]))
            ->assertUnauthorized();
    }
}
