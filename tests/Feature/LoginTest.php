<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
// use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_can_login_as_admin()
    {
        $user = $this->adminUser();

        $this->postJson(route('login'), ['email' => $user->email, 'password' => TestCase::AUTH_PASSWORD])
            ->assertStatus(200)
            ->assertJsonStructure([
                'user' => ['id' , 'status', 'name', 'email', 'email_verified_at', 'photo_url', 'roles_list', 'roles'],
                'token',
            ]);
    }

    /** @test */
    public function it_can_login_as_user()
    {
        $user = $this->user();

        $this->postJson(route('login'), ['email' => $user->email, 'password' => TestCase::AUTH_PASSWORD])
            ->assertStatus(200)
            ->assertJsonStructure([
                'user' => ['id' , 'status', 'name', 'email', 'email_verified_at', 'photo_url', 'roles_list', 'roles'],
                'token',
            ]);
    }

    /** @test */
    public function it_can_not_login_without_email()
    {
        $this->postJson(route('login'), ['email' => '', 'password' => TestCase::AUTH_PASSWORD])
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['email']]);
    }

    /** @test */
    public function it_can_not_login_without_password()
    {
        $user = $this->adminUser();

        $this->postJson(route('login'), ['email' => $user->email, 'password' => ''])
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['password']]);
    }

    /** @test */
    public function it_can_not_login_with_empty_form()
    {
        $this->withHeader('fart', 'caca');

        $this->postJson(route('login'), ['email' => '', 'password' => ''])
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['email', 'password']]);
    }

    /** @test */
    public function it_can_logout_as_admin()
    {
        $token = $this->getTokenForUser($this->adminUser());

        $this->postJson(route('logout'), [], ['Authorization' => "Bearer $token"])
            ->assertStatus(200)
            ->assertJsonStructure(['success']);
    }

    /** @test */
    public function it_can_logout_as_user()
    {
        $token = $this->getTokenForUser($this->user());

        $this->postJson(route('logout'), [], ['Authorization' => "Bearer $token"])
            ->assertStatus(200)
            ->assertJsonStructure(['success']);
    }
}
