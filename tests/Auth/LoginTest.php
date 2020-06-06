<?php

namespace Tests\Auth;

use Illuminate\Foundation\Testing\DatabaseTransactions;
// use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Auth;

class LoginTest extends TestCase
{
    use DatabaseTransactions, ThrottlesLogins;

    protected $auth_guard = 'web';

    /** @test */
    public function it_should_login_as_admin()
    {
        $user = $this->adminUser();

        $this->postJson(route('login'), ['email' => $user->email, 'password' => TestCase::AUTH_PASSWORD])
            ->assertStatus(200)
            ->assertJsonStructure([
                'user' => [
                    'id' ,
                    'status',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                    'photo_url',
                    'roles_list',
                    'roles',
                ],
            ]);

        $this->assertEquals(Auth::check(), true);
        $this->assertEquals(Auth::user()->email, $user->email);
        $this->assertAuthenticated($this->auth_guard);
        $this->assertAuthenticatedAs($user, $this->auth_guard);
    }

    /** @test */
    public function it_should_login_as_user()
    {
        $user = $this->user();

        $this->postJson(route('login'), ['email' => $user->email, 'password' => TestCase::AUTH_PASSWORD])
            ->assertStatus(200)
            ->assertJsonStructure([
                'user' => [
                    'id' ,
                    'status',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                    'photo_url',
                    'roles_list',
                    'roles',
                ],
            ]);

        $this->assertEquals(Auth::check(), true);
        $this->assertEquals(Auth::user()->email, $user->email);
        $this->assertAuthenticated($this->auth_guard);
        $this->assertAuthenticatedAs($user, $this->auth_guard);
    }

    /** @test */
    public function it_should_throw_error_422_on_login_attempt_without_email()
    {
        $this->postJson(route('login'), ['email' => '', 'password' => TestCase::AUTH_PASSWORD])
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['email']]);

        $this->assertGuest($this->auth_guard);
    }

    /** @test */
    public function it_should_throw_error_422_on_login_attempt_without_password()
    {
        $this->postJson(route('login'), ['email' => $this->adminUser()->email, 'password' => ''])
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['password']]);

        $this->assertGuest($this->auth_guard);
    }

    /** @test */
    public function it_should_throw_error_422_on_login_attempt_with_empty_form()
    {
        $this->postJson(route('login'), ['email' => '', 'password' => ''])
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['email', 'password']]);

        $this->assertGuest($this->auth_guard);
    }

    /** @test */
    public function it_should_logout_as_admin()
    {
        $this->actingAs($this->adminUser())->postJson(route('logout'))
            ->assertStatus(200)
            ->assertJson(['success' => 'LOGGED_OUT']);

        $this->assertGuest($this->auth_guard);
    }

    /** @test */
    public function it_should_logout_as_user()
    {
        $this->actingAs($this->user())->postJson(route('logout'))
            ->assertStatus(200)
            ->assertJson(['success' => 'LOGGED_OUT']);

        $this->assertGuest($this->auth_guard);
    }

    /** @test */
    public function it_should_throw_error_401_as_guest_on_protected_routes()
    {
        $this->getJson(route('me'))
            ->assertStatus(401)
            ->assertJson(['error' => 'UNAUTHENTICATED']);
    }

    /** @test */
    public function it_should_throw_error_400_as_admin_on_protected_routes()
    {
        $this->getJson(route('me'))
            ->assertStatus(401)
            ->assertJson(['error' => 'UNAUTHENTICATED']);
    }

    /** @test */
    public function it_should_throw_error_429_when_login_attempt_is_throttled()
    {
        $user = $this->user();
        $this->postJson(route('login'), ['email' => $user->email, 'password' => TestCase::AUTH_PASSWORD . '1']);

        \Log::debug('made it to the end');
        $this->postJson(route('login'), ['email' => $user->email, 'password' => TestCase::AUTH_PASSWORD . '2'])
            ->assertStatus(429)
            ->assertJson(['error' => 'UNAUTHENTICATED']);
    }

}
