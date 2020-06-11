<?php

namespace Tests\Auth;

use App\User;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
// use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Auth;

/**
 * When making multiple requests in one test, the state of the Laravel API would not reset between the requests.
 * The AuthManager is a singleton in the laravel container, and it keeps a local cache of the resolved auth guards.
 * `$this->resetAuth()` is used to reset any session-remnants between unit tests.
 * Theory: https://stackoverflow.com/a/57941133/6141025
 */

class LoginTest extends TestCase
{
    use DatabaseTransactions, ThrottlesLogins;

    protected $auth_guard = 'web';

    /** @test */
    public function it_can_login()
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

        $this->resetAuth();
    }

    /** @test */
    public function it_can_logout()
    {
        $this->actingAs($this->user())
            ->postJson(route('logout'))
            ->assertStatus(204);

        $this->assertGuest($this->auth_guard);

        $this->resetAuth();
    }

    /** @test */
    public function it_should_get_two_cookies_without_remember_me()
    {
        $user = $this->user();

        $response = $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => TestCase::AUTH_PASSWORD,
        ]);

        $response->assertCookieNotExpired(Str::slug(config('app.name'), '_').'_session');
        $response->assertCookieNotExpired('XSRF-TOKEN');
        $this->assertEquals(config('session.http_only'), true);

        $this->resetAuth();
    }

    /** @test */
    public function it_should_get_three_cookies_with_remember_me()
    {
        $user = $this->user();

        $response = $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => TestCase::AUTH_PASSWORD,
            'remember' => true,
        ]);

        $response->assertCookieNotExpired(Str::slug(config('app.name'), '_').'_session');
        $response->assertCookieNotExpired('XSRF-TOKEN');
        $response->assertCookieNotExpired(Auth::getRecallerName());

        $this->resetAuth();
    }

    /** @test */
    public function it_should_throw_error_422_on_login_attempt_without_email()
    {
        $this->postJson(route('login'), ['email' => '', 'password' => TestCase::AUTH_PASSWORD])
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['email']]);

        $this->assertGuest($this->auth_guard);

        $this->resetAuth();
    }

    /** @test */
    public function it_should_throw_error_422_on_login_attempt_without_password()
    {
        $this->postJson(route('login'), ['email' => $this->adminUser()->email, 'password' => ''])
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['password']]);

        $this->assertGuest($this->auth_guard);

        $this->resetAuth();
    }

    /** @test */
    public function it_should_throw_error_422_on_login_attempt_with_empty_form()
    {
        $this->postJson(route('login'), ['email' => '', 'password' => ''])
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['email', 'password']]);

        $this->assertGuest($this->auth_guard);

        $this->resetAuth();
    }

    /** @test */
    public function it_should_throw_error_401_as_guest_on_protected_routes()
    {
        $this->assertGuest($this->auth_guard);

        $this->getJson(route('me'))
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    /** @test */
    public function it_should_throw_error_429_when_login_attempt_is_throttled()
    {
        $this->resetAuth();

        $throttledUser = factory(User::class, 1)->create()->first();

        foreach (range(0, 9) as $attempt) {
            $this->postJson(route('login'), ['email' => $throttledUser->email, 'password' => "{TestCase::AUTH_PASSWORD}_{$attempt}"]);
        }

        $this->postJson(route('login'), ['email' => $throttledUser->email, 'password' => TestCase::AUTH_PASSWORD . '6'])
            ->assertStatus(429)
            ->assertJson(['message' => 'Too Many Attempts.']);

        $this->resetAuth();
    }

}
