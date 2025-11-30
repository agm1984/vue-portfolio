<?php

namespace Tests\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;

    protected $auth_guard = 'web';

    #[Test]
    public function it_can_register()
    {
        $new_user = [
            'name' => 'Test Person',
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $this->postJson(route('register'), $new_user)
            ->assertStatus(200)
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'status',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'avatar_url',
                    'roles_list',
                    'roles',
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'name' => $new_user['name'],
            'email' => $new_user['email'],
        ]);

        $hashedPassword = User::query()->firstWhere('email', $new_user['email'])->password;
        $this->assertTrue(Hash::check($new_user['password'], $hashedPassword), true);

        $this->resetAuth();
    }

    #[Test]
    public function it_should_get_two_cookies()
    {
        $new_user = [
            'name' => 'Test Person',
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $response = $this->postJson(route('register'), $new_user);

        $response->assertCookieNotExpired(Str::slug(config('app.name'), '_') . '_session');
        $response->assertCookieNotExpired('XSRF-TOKEN');
        $this->assertEquals(config('session.http_only'), true);

        $this->resetAuth();
    }


    #[Test]
    public function it_should_throw_error_422_without_a_name()
    {
        $this->postJson(route('register'), [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password',
        ])
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['name']]);
    }

    #[Test]
    public function it_should_throw_error_422_with_a_name_too_long()
    {
        $this->postJson(route('register'), [
            'name' => Str::random(256),
            'email' => 'test@example.com',
            'password' => 'password',
        ])
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['name']]);
    }

    #[Test]
    public function it_should_throw_error_422_without_an_email()
    {
        $this->postJson(route('register'), [
            'name' => 'Test Person',
            'email' => '',
            'password' => 'password',
        ])
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['email']]);
    }

    #[Test]
    public function it_should_throw_error_422_with_an_email_too_long()
    {
        $this->postJson(route('register'), [
            'name' => 'Test Person',
            'email' => Str::random(256),
            'password' => 'password',
        ])
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['email']]);
    }

    #[Test]
    public function it_should_throw_error_422_with_an_existing_email()
    {
        $dupe_user = [
            'name' => 'Test Person',
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $this->postJson(route('register'), $dupe_user);

        $this->assertDatabaseHas('users', [
            'name' => $dupe_user['name'],
            'email' => $dupe_user['email'],
        ]);

        $this->resetAuth();

        $this->postJson(route('register'), [
            'name' => 'Test Person',
            'email' => 'test@example.com',
            'password' => 'password',
        ])
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['email']]);

        $this->assertGuest($this->auth_guard);
    }

    #[Test]
    public function it_should_throw_error_422_without_password()
    {
        $this->postJson(route('register'), [
            'name' => 'Test Person',
            'email' => 'test@example.com',
            'password' => '',
        ])
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['password']]);
    }

    #[Test]
    public function it_should_throw_error_422_with_empty_form()
    {
        $this->postJson(route('register'), [
            'name' => '',
            'email' => '',
            'password' => '',
        ])
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['name', 'email', 'password']]);
    }
}
