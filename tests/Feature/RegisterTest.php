<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
// use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_can_register()
    {
        $this->postJson(route('register'), [
            'name' => 'Test Person',
            'email' => 'test@example.com',
            'password' => 'password',
        ])
        ->assertStatus(200)
        ->assertJsonStructure([
            'user' => ['id', 'name', 'email', 'photo_url', 'roles_list', 'roles'],
            'token',
            'token_type',
            'expires_in',
        ]);
    }

    /** @test */
    public function it_can_not_register_without_a_name()
    {
        $this->postJson(route('register'), [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password',
        ])
        ->assertStatus(422)
        ->assertJsonStructure(['message', 'errors' => ['name']]);
    }

    /** @test */
    public function it_can_not_register_with_a_name_too_long()
    {
        $this->postJson(route('register'), [
            'name' => Str::random(256),
            'email' => 'test@example.com',
            'password' => 'password',
        ])
        ->assertStatus(422)
        ->assertJsonStructure(['message', 'errors' => ['name']]);
    }

    /** @test */
    public function it_can_not_register_without_an_email()
    {
        $this->postJson(route('register'), [
            'name' => 'Test Person',
            'email' => '',
            'password' => 'password',
        ])
        ->assertStatus(422)
        ->assertJsonStructure(['message', 'errors' => ['email']]);
    }

    /** @test */
    public function it_can_not_register_with_an_email_too_long()
    {
        $this->postJson(route('register'), [
            'name' => 'Test Person',
            'email' => Str::random(256),
            'password' => 'password',
        ])
        ->assertStatus(422)
        ->assertJsonStructure(['message', 'errors' => ['email']]);
    }

    /** @test */
    public function it_can_not_register_with_an_existing_email()
    {
        $this->postJson(route('register'), [
            'name' => 'Test Person',
            'email' => 'test@example.com',
            'password' => 'password',
        ])
        ->assertStatus(200)
        ->assertJsonStructure([
            'user' => ['id' , 'name', 'email', 'photo_url', 'roles_list', 'roles'],
            'token',
            'token_type',
            'expires_in',
        ]);

        Auth::logout();

        $this->postJson(route('register'), [
            'name' => 'Test Person',
            'email' => 'test@example.com',
            'password' => 'password',
        ])
        ->assertStatus(422)
        ->assertJsonStructure(['message', 'errors' => ['email']]);
    }

    /** @test */
    public function it_can_not_register_without_password()
    {
        $this->postJson(route('register'), [
            'name' => 'Test Person',
            'email' => 'test@example.com',
            'password' => '',
        ])
        ->assertStatus(422)
        ->assertJsonStructure(['message', 'errors' => ['password']]);
    }

    /** @test */
    public function it_can_not_register_with_empty_form()
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
