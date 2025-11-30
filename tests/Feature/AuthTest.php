<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use JWTAuth;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    // #[Test]
    // public function it_can_do_something()
    // {
    //     $token = $this->getTokenForUser($this->user());

    //     $token = JWTAuth::fromUser($this->user());
    //     $payload = JWTAuth::setToken($token)->getPayload();

    //     \Log::debug(auth()->user());

    //     JWTAuth::invalidate();

    //     \Log::debug(json_encode(JWTAuth::manager()->getBlacklist()));

    //     $this->assertTrue(JWTAuth::manager()->getBlacklist()->has($payload));

    //     $this->postJson(route('logout'), [], ['Authorization' => "Bearer $token"])
    //         ->assertStatus(401)
    //         ->assertJsonStructure(['error']);
    // }

    // it_can_refresh_token_during_JWT_REFRESH_TTL

    // it_cannot_refresh_token_after_JWT_REFRESH_TTL

    // it_can_logout_while_token_is_expired
}
