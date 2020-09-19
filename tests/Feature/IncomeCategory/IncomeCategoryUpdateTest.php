<?php

namespace Tests\Feature\IncomeCategory;

use App\User;
use App\IncomeCategory;
use Illuminate\Support\Str;
use Tests\IntegrationTestCase;

class IncomeCategoryUpdateTest extends IntegrationTestCase
{
    protected $category;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->category = IncomeCategory::factory()->create(['user_id' => $this->user]);
    }

    /** @test */
    public function a_user_can_ajax_patch_an_income_category_that_owns()
    {
        $this->signIn($this->user);

        $this->patchJson(route('income.category', ['category' => $this->category]), IncomeCategory::factory()->raw())
            ->assertOk();
    }

    /** @test */
    public function a_user_cannot_patch_an_income_category_that_belongs_to_other_user()
    {
        $this->signIn();

        $this->patchJson(route('income.category', ['category' => $this->category]), IncomeCategory::factory()->raw())
            ->assertNotFound();
    }

    /** @test */
    public function a_guest_cannot_patch_an_income_categories()
    {
        $this->patchJson(route('income.category', ['category' => $this->category]), IncomeCategory::factory()->raw())
            ->assertUnauthorized();
    }

    /** @test */
    public function an_income_category_requires_a_name()
    {
        $this->signIn($this->user);

        $this->patchCategory($this->categoryRaw(['name' => '']))
            ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function income_category_name_has_a_max_length()
    {
        $this->signIn($this->user);

        $this->patchCategory($this->categoryRaw(['name' => Str::random(191)]))
            ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function income_category_name_must_be_unique()
    {
        $this->signIn($this->user);

        IncomeCategory::factory()->create(['name' => 'test']);

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
        return $this->patchJson(route('income.category', ['category' => $this->category]), $data);
    }

    /**
     * Category raw data
     *
     * @param array $overrides
     * @return array|mixed
     */
    protected function categoryRaw($overrides = [])
    {
        return IncomeCategory::factory()->raw($overrides);
    }
}
