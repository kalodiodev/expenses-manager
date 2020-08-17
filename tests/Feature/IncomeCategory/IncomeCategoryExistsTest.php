<?php

namespace Tests\Feature\IncomeCategory;

use App\User;
use App\IncomeCategory;
use Tests\IntegrationTestCase;

class IncomeCategoryExistsTest extends IntegrationTestCase
{
    /** @test */
    public function an_authenticated_user_can_check_if_category_name_exists()
    {
        $user = $this->signIn();

        $category = factory(IncomeCategory::class)->create(['user_id' => $user->id]);

        $this->postJson(route('income.category.exists'), ['name' => $category->name])
            ->assertJson(['exists' => true]);
    }

    /** @test */
    public function other_users_categories_names_not_considered()
    {
        $this->signIn();

        $category = factory(IncomeCategory::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $this->postJson(route('income.category.exists'), ['name' => $category->name])
            ->assertJson(['exists' => false]);
    }
}
