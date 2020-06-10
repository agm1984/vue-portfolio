<?php

namespace Tests;

use App\User;
use Illuminate\Auth\SessionGuard;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\Models\Role;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions;

    const AUTH_PASSWORD = 'password';

    public function setUp() : void
    {
        parent::setUp();
    }

    public function tearDown() : void
    {
        parent::tearDown();
    }

    protected function resetAuth(array $guards = null) : void
    {
        $guards = $guards ?: array_keys(config('auth.guards'));

        foreach ($guards as $guard) {
            $guard = $this->app['auth']->guard($guard);

            if ($guard instanceof SessionGuard) {
                $guard->logout();
            }
        }

        $protectedProperty = new \ReflectionProperty($this->app['auth'], 'guards');
        $protectedProperty->setAccessible(true);
        $protectedProperty->setValue($this->app['auth'], []);
    }

    /**
     * Creates and/or returns the designated admin user for unit testing
     *
     * @return \App\User
     */
    public function adminUser() : User
    {
        $user = User::query()->firstWhere('email', 'test-admin@example.com');

        if ($user) {
            return $user;
        }

        $user = User::generate('Test Admin', 'test-admin@example.com', self::AUTH_PASSWORD);

        $user->assignRole(Role::findByName('admin'));

        return $user;
    }

    /**
     * Creates and/or returns the designated regular user for unit testing
     *
     * @return \App\User
     */
    public function user() : User
    {
        $user = User::query()->firstWhere('email', 'test-user@example.com');

        if ($user) {
            return $user;
        }

        $user = User::generate('Test User', 'test-user@example.com', self::AUTH_PASSWORD);

        return $user;
    }
}
