<?php

namespace Tests\Feature\Income;

use App\Income;
use Illuminate\Support\Str;
use Tests\IntegrationTestCase;

class IncomeCreateTest extends IntegrationTestCase
{
    /** @test */
    public function a_user_can_ajax_post_an_income()
    {
        $this->signIn();

        $this->postJson(route('incomes'), factory(Income::class)->raw())
            ->assertCreated();
    }

    /** @test */
    public function a_guest_cannot_post_an_income()
    {
        $this->postJson(route('incomes'), factory(Income::class)->raw())
            ->assertUnauthorized();
    }
}
