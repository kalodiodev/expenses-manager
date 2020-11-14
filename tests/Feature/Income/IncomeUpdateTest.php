<?php

namespace Tests\Feature\income;

use App\Income;
use Illuminate\Support\Str;
use Tests\IntegrationTestCase;

class IncomeUpdateTest extends IntegrationTestCase
{
    protected $income;

    public function setUp(): void
    {
        parent::setUp();

        $this->income = Income::factory()->create();
    }

    /** @test */
    public function a_user_can_ajax_patch_an_income_that_owns()
    {
        $user = $this->signIn();

        $income = Income::factory()->create(['user_id' => $user->id]);

        $this->patchJson(route('income', ['income' => $income->id]), $new = Income::factory()->raw())
            ->assertOk();

        $this->assertEquals($new['description'], $income->fresh()->description);
        $this->assertEquals($new['amount'], $income->fresh()->amount);
    }

    /** @test */
    public function a_user_cannot_patch_an_income_that_belongs_to_other_user()
    {
        $this->signIn();

        $this->patchJson(route('income', ['income' => $this->income->id]), $new = Income::factory()->raw())
            ->assertNotFound();
    }

    /** @test */
    public function a_guest_cannot_patch_an_income()
    {
        $this->patchJson(route('income', ['income' => $this->income->id]), $new =  Income::factory()->raw())
            ->assertUnauthorized();
    }

    /** @test */
    public function an_income_requires_a_category()
    {
        $this->signIn();

        $this->patchJson(route('income', ['income' => $this->income->id]),  Income::factory()->raw(['category_id' => '']))
            ->assertJsonValidationErrors('category_id');
    }

    /** @test */
    public function an_income_requires_a_category_that_exists()
    {
        $this->signIn();

        $this->patchJson(route('income', ['income' => $this->income->id]), Income::factory()->raw(['category_id' => 100]))
            ->assertJsonValidationErrors('category_id');
    }

    /** @test */
    public function an_income_requires_a_valid_date()
    {
        $this->signIn();

        $this->patchJson(route('income', ['income' => $this->income->id]), Income::factory()->raw(['date' => '']))
            ->assertJsonValidationErrors('date');

        $this->patchJson(route('income', ['income' => $this->income->id]), Income::factory()->raw(['date' => 'string']))
            ->assertJsonValidationErrors('date');
    }

    /** @test */
    public function an_income_requires_a_valid_cost()
    {
        $this->signIn();

        $this->patchJson(route('income', ['income' => $this->income->id]), Income::factory()->raw(['amount' => '']))
            ->assertJsonValidationErrors('amount');

        $this->patchJson(route('income', ['income' => $this->income->id]), Income::factory()->raw(['amount' => 'amount']))
            ->assertJsonValidationErrors('amount');

        $this->patchJson(route('income', ['income' => $this->income->id]), Income::factory()->raw(['amount' => -10]))
            ->assertJsonValidationErrors('amount');
    }

    /** @test */
    public function an_income_description_has_a_max_length()
    {
        $this->signIn();

        $this->patchJson(route('income', ['income' => $this->income->id]), Income::factory()->raw(['description' => Str::random(191)]))
            ->assertJsonValidationErrors('description');
    }
}
