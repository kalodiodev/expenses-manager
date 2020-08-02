<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class IntegrationTestCase extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(\DatabaseSeeder::class);
    }

    /**
     * Sign in a user with a given role
     *
     * @param User|null $user
     * @return mixed
     */
    protected function signIn(User $user = null)
    {
        if (! $user) {
            $user = factory(User::class)->create();
        }

        $this->actingAs($user);

        return $user;
    }
}
