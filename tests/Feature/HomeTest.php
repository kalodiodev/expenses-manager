<?php

namespace Tests\Feature;

use Tests\IntegrationTestCase;

class HomeTest extends IntegrationTestCase
{
    /** @test */
    public function an_authenticated_user_can_visit_home()
    {
        $this->signIn();

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
        $this->signIn();

        $this->get(route('expense.categories'))
            ->assertRedirect(route('home'));
    }
}
