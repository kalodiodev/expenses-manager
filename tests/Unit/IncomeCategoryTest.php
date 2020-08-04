<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use App\IncomeCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IncomeCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_expense_category_belongs_to_a_user()
    {
        $category = factory(IncomeCategory::class)->create();

        $this->assertInstanceOf(User::class, $category->user);
    }
}
