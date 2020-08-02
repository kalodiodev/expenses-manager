<?php

namespace Tests\Feature\ExpenseCategory;

use App\User;
use Tests\TestCase;
use App\ExpenseCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_visit_home()
    {
        $this->actingAs(factory(User::class)->create());

        $this->get(route('home'))
            ->assertOk()
            ->assertViewIs('home');
    }

    /** @test */
    public function a_guest_cannot_visit_home()
    {
        $this->get(route('home'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function a_non_ajax_request_redirects_to_home()
    {
        $this->actingAs(factory(User::class)->create());

        $this->get(route('expense.categories'))
            ->assertRedirect(route('home'));
    }
}
