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

        $this->postJson(route('incomes'), Income::factory()->raw())
            ->assertCreated();
    }

    /** @test */
    public function a_guest_cannot_post_an_income()
    {
        $this->postJson(route('incomes'), Income::factory()->raw())
            ->assertUnauthorized();
    }

    /** @test */
    public function an_income_requires_a_category()
    {
        $this->signIn();

        $this->postJson(route('incomes'), Income::factory()->raw(['category_id' => '']))
            ->assertJsonValidationErrors('category_id');
    }

    /** @test */
    public function an_income_requires_a_category_that_exists()
    {
        $this->signIn();

        $this->postJson(route('incomes'), Income::factory()->raw(['category_id' => 100]))
            ->assertJsonValidationErrors('category_id');
    }

    /** @test */
    public function an_income_requires_a_valid_date()
    {
        $this->signIn();

        $this->postJson(route('incomes'), Income::factory()->raw(['date' => '']))
            ->assertJsonValidationErrors('date');

        $this->postJson(route('incomes'), Income::factory()->raw(['date' => 'string']))
            ->assertJsonValidationErrors('date');
    }

    /** @test */
    public function an_income_requires_a_valid_amount()
    {
        $this->signIn();

        $this->postJson(route('incomes'), Income::factory()->raw(['amount' => '']))
            ->assertJsonValidationErrors('amount');

        $this->postJson(route('incomes'), Income::factory()->raw(['amount' => 'string']))
            ->assertJsonValidationErrors('amount');

        $this->postJson(route('incomes'), Income::factory()->raw(['amount' => -10]))
            ->assertJsonValidationErrors('amount');
    }

    /** @test */
    public function an_income_description_has_a_max_length()
    {
        $this->signIn();

        $this->postJson(route('incomes'), Income::factory()->raw(['description' => Str::random(191)]))
            ->assertJsonValidationErrors('description');
    }
}
