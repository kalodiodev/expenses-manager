<?php

namespace Tests\Feature\IncomeCategory;

use App\IncomeCategory;
use Illuminate\Support\Str;
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

    /** @test */
    public function an_income_category_requires_a_name()
    {
        $this->signIn();

        $this->postJson(route('income.categories'), factory(IncomeCategory::class)->raw(['name' => '']))
            ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function income_category_name_has_a_max_length()
    {
        $this->signIn();

        $this->postJson(route('income.categories'), factory(IncomeCategory::class)->raw(['name' => Str::random(191)]))
            ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function expense_category_name_must_be_unique()
    {
        $this->signIn();

        factory(IncomeCategory::class)->create(['name' => 'test']);

        $this->postJson(route('income.categories'), factory(IncomeCategory::class)->raw(['name' => 'test']))
            ->assertJsonValidationErrors('name');
    }
}
