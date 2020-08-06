<?php

namespace Tests\Feature\IncomeCategory;

use App\IncomeCategory;
use Tests\IntegrationTestCase;

class IncomeCategoryUpdateTest extends IntegrationTestCase
{
    protected $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->category = factory(IncomeCategory::class)->create();
    }

    /** @test */
    public function a_user_can_ajax_patch_an_income_category()
    {
        $this->signIn();

        $this->patchJson(route('income.category', ['category' => $this->category]), factory(IncomeCategory::class)->raw())
            ->assertOk();
    }

    /** @test */
    public function a_guest_cannot_patch_an_income_categories()
    {
        $this->patchJson(route('income.category', ['category' => $this->category]), factory(IncomeCategory::class)->raw())
            ->assertUnauthorized();
    }
}
