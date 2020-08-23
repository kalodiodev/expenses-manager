<?php

namespace Tests\Feature\ExpenseCategory;

use App\User;
use App\ExpenseCategory;
use Illuminate\Support\Str;
use Tests\IntegrationTestCase;

class ExpenseCategoryUpdateTest extends IntegrationTestCase
{
    protected $category;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->category = factory(ExpenseCategory::class)->create(['user_id' => $this->user->id]);
    }

    /** @test */
    public function a_user_can_ajax_patch_an_expense_category_that_owns()
    {
        $this->signIn($this->user);

        $this->patchCategory($this->categoryRaw())
            ->assertOk();
    }

    /** @test */
    public function a_user_cannot_patch_an_expense_category_that_belongs_to_other_user()
    {
        $this->signIn();

        $this->patchCategory($this->categoryRaw())
            ->assertNotFound();
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
        $this->signIn($this->user);

        $this->patchCategory($this->categoryRaw(['name' => '']))
            ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function expense_category_name_has_a_max_length()
    {
        $this->signIn($this->user);

        $this->patchCategory($this->categoryRaw(['name' => Str::random(191)]))
            ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function expense_category_name_must_be_unique()
    {
        $this->signIn($this->user);

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
