<?php

namespace Tests\Feature\IncomeCategory;

use App\IncomeCategory;
use Tests\IntegrationTestCase;

class IncomeCategoryCreateTest extends IntegrationTestCase
{
    /** @test */
    public function a_user_can_ajax_post_an_income_category()
    {
        $this->signIn();

        $this->postJson(route('income.categories'), factory(IncomeCategory::class)->raw())
            ->assertCreated();
    }

    /** @test */
    public function a_guest_cannot_post_an_income_category()
    {
        $this->postJson(route('income.categories'), factory(IncomeCategory::class)->raw())
            ->assertUnauthorized();
    }
}
