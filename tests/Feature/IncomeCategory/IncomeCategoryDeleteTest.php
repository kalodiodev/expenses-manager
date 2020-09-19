<?php

namespace Tests\Feature\IncomeCategory;

use App\IncomeCategory;
use Tests\IntegrationTestCase;

class IncomeCategoryDeleteTest extends IntegrationTestCase
{
    protected $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->category = IncomeCategory::factory()->create();
    }

    /** @test */
    public function a_user_can_ajax_delete_an_income_category_that_owns()
    {
        $user = $this->signIn();

        $category = IncomeCategory::factory()->create(['user_id' => $user->id]);

        $this->deleteJson(route('income.category', ['category' => $category]))
            ->assertNoContent();
    }

    /** @test */
    public function a_user_cannot_delete_an_income_category_that_belongs_to_other_user()
    {
        $this->signIn();

        $this->deleteJson(route('income.category', ['category' => $this->category]))
            ->assertNotFound();
    }


    /** @test */
    public function a_guest_cannot_delete_an_income_category()
    {
        $this->deleteJson(route('income.category', ['category' => $this->category]))
            ->assertUnauthorized();
    }
}
