<?php

namespace Tests\Feature\ExpenseCategory;

use App\ExpenseCategory;
use Illuminate\Support\Str;
use Tests\IntegrationTestCase;

class ExpenseCategoryUpdateTest extends IntegrationTestCase
{
    protected $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->category = factory(ExpenseCategory::class)->create();
    }

    /** @test */
    public function a_user_can_ajax_patch_an_expense_category()
    {
        $this->signIn();

        $this->patchCategory($this->categoryRaw())
            ->assertOk();
    }

    /** @test */
    public function a_guest_cannot_patch_an_expense_categories()
    {
        $this->patchCategory($this->categoryRaw())
            ->assertUnauthorized();
    }

    /** @test */
    public function an_expense_category_requires_a_name()
    {
        $this->signIn();

        $this->patchCategory($this->categoryRaw(['name' => '']))
            ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function expense_category_name_has_a_max_length()
    {
        $this->signIn();

        $this->patchCategory($this->categoryRaw(['name' => Str::random(191)]))
            ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function expense_category_name_must_be_unique()
    {
        $this->signIn();

        factory(ExpenseCategory::class)->create(['name' => 'test']);

        $this->patchCategory($this->categoryRaw(['name' => $this->category->name]))
            ->assertJsonMissingValidationErrors();

        $this->patchCategory($this->categoryRaw(['name' => 'test']))
            ->assertJsonValidationErrors('name');
    }

    /**
     * Json patch category
     *
     * @param $data
     * @return \Illuminate\Testing\TestResponse
     */
    protected function patchCategory($data)
    {
        return $this->patchJson(route('expense.category', ['category' => $this->category]), $data);
    }

    /**
     * Category raw data
     *
     * @param array $overrides
     * @return array|mixed
     */
    protected function categoryRaw($overrides = [])
    {
        return factory(ExpenseCategory::class)->raw($overrides);
    }
}
