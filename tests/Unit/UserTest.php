<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function a_user_has_expense_categories()
    {
        $this->assertInstanceOf(Collection::class, $this->user->expenseCategories);
    }

    /** @test */
    public function a_user_has_income_categories()
    {
        $this->assertInstanceOf(Collection::class, $this->user->incomeCategories);
    }

    /** @test */
    public function a_user_has_expenses()
    {
        $this->assertInstanceOf(Collection::class, $this->user->expenses);
    }
}
