<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_user_has_projects(): void
    {
        $user = User::factory()->create();

        self::assertInstanceOf(Collection::class, $user->projects);
    }
}
