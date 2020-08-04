<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_expense_categories()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->expenseCategories);
    }

    /** @test */
    public function a_user_has_income_categories()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->incomeCategories);
    }
}
