<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\Models\Role;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions;

    public function setUp() : void
    {
        parent::setUp();
    }

    public function tearDown() : void
    {
        parent::tearDown();
        // gc_collect_cycles();
    }

    public function adminUser() : User
    {
        $user = User::query()->firstWhere('email', 'test-admin@example.com');

        if ($user) {
            return $user;
        }

        $user = User::generate('Test Admin', 'test-admin@example.com', 'password');

        $user->assignRole(Role::findByName('admin'));

        return $user;
    }

    public function user() : User
    {
        $user = User::query()->firstWhere('email', 'test-user@example.com');

        if ($user) {
            return $user;
        }

        $user = User::generate('Test User', 'test-user@example.com', 'password');

        return $user;
    }
}
