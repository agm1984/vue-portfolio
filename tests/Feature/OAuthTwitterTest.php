<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
// use Illuminate\Foundation\Testing\WithFaker;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Assert as PHPUnit;
use Tests\TestCase;
use App\Http\Controllers\Auth\TwitterClient;

class OAuthTwitterTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        TestResponse::macro('assertText', function ($text) {
            PHPUnit::assertTrue(Str::contains($this->getContent(), $text), "Expected text [{$text}] not found.");

            return $this;
        });

        TestResponse::macro('assertTextMissing', function ($text) {
            PHPUnit::assertFalse(Str::contains($this->getContent(), $text), "Expected missing text [{$text}] found.");

            return $this;
        });
    }

    /**
     * Mocks the TwitterOAuth API that communicates externally.
     *
     * @param array|null $user
     * @return void
     */
    protected function mockTwitterOAuth(?array $user = null)
    {
        $mock = $this->mock(TwitterClient::class);

        $mock->shouldReceive('getUrl')->andReturn('https://url-to-provider');

        if ($user) {
            $mock->shouldReceive('getUser')->andReturn($user);
        }
    }

    /** @test */
    public function it_can_redirect_to_twitter()
    {
        $this->mockTwitterOAuth();

        $this->postJson('/api/oauth/twitter')
            ->assertStatus(200)
            ->assertJson(['url' => 'https://url-to-provider']);
    }

    /** @test */
    public function it_can_create_new_user_from_twitter_identity()
    {
        $twitter_identity = [
            'id' => '123',
            'name' => 'New Twitter User',
            'email' => 'new-twitter@example.com',
            'token' => 'access-token',
            'refreshToken' => null,
        ];

        $this->mockTwitterOAuth($twitter_identity);

        $this->withoutExceptionHandling();

        $this->get('/api/oauth/twitter/callback')
            ->assertText('token')
            ->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'name' => $twitter_identity['name'],
            'email' => $twitter_identity['email'],
        ]);

        $this->assertDatabaseHas('oauth_providers', [
            'user_id' => User::query()->firstWhere('email', $twitter_identity['email'])->id,
            'provider' => 'twitter',
            'provider_user_id' => $twitter_identity['id'],
            'access_token' => $twitter_identity['token'],
            'refresh_token' => $twitter_identity['refreshToken'],
        ]);
    }

    /** @test */
    public function it_can_update_twitter_identity_for_existing_user()
    {
        $existing_user = $this->user();

        $existing_user->oauthProviders()->create([
            'provider' => 'twitter',
            'provider_user_id' => '123',
            'access_token' => 'access-token',
            'refresh_token' => null,
        ]);

        $updated_twitter_identity = [
            'id' => '123',
            'name' => 'Updated Twitter User',
            'email' => $existing_user->email,
            'token' => 'updated-access-token',
            'refreshToken' => null,
        ];

        $this->mockTwitterOAuth($updated_twitter_identity);

        $this->withoutExceptionHandling();

        $this->get('/api/oauth/twitter/callback')
            ->assertText('token')
            ->assertSuccessful();

        $this->assertDatabaseHas('oauth_providers', [
            'user_id' => $existing_user->id,
            'access_token' => $updated_twitter_identity['token'],
            'refresh_token' => $updated_twitter_identity['refreshToken'],
        ]);
    }

    /** @test */
    public function it_can_add_twitter_identity_to_existing_user()
    {
        $existing_user = $this->user();

        $this->assertTrue($existing_user->oauthProviders->count() === 0);

        $twitter_identity = [
            'id' => '123',
            'name' => 'New Twitter User',
            'email' => $existing_user->email,
            'token' => 'access-token',
            'refreshToken' => null,
        ];

        $this->mockTwitterOAuth($twitter_identity);

        $this->withoutExceptionHandling();

        $this->get('/api/oauth/twitter/callback')
            ->assertText('token')
            ->assertSuccessful();

        $this->assertDatabaseHas('oauth_providers', [
            'user_id' => User::query()->firstWhere('email', $twitter_identity['email'])->id,
            'provider' => 'twitter',
            'provider_user_id' => $twitter_identity['id'],
            'access_token' => $twitter_identity['token'],
            'refresh_token' => $twitter_identity['refreshToken'],
        ]);
    }

}
