<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\OauthProvider;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery as m;
use PHPUnit\Framework\Assert as PHPUnit;
use Tests\TestCase;

class OAuthGitHubTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp() : void
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

    public function tearDown() : void
    {
        parent::tearDown();

        m::close();
    }

    /**
     * Mocks the Socialite API that communicates externally.
     *
     * @param string $provider
     * @param array $user
     * @return void
     */
    protected function mockSocialite(string $provider, ?array $user = null)
    {
        $mock = Socialite::shouldReceive('stateless')
            ->andReturn(m::self())
            ->shouldReceive('driver')
            ->with($provider)
            ->andReturn(m::self());

        if ($user) {
            $mock->shouldReceive('user')
                ->andReturn((new SocialiteUser)->setRaw($user)->map($user));
        } else {
            $mock->shouldReceive('redirect')
                ->andReturn(redirect('https://url-to-provider'));
        }
    }

    /** @test */
    public function it_redirects_to_github()
    {
        $this->mockSocialite('github');

        $this->postJson(route('oauth.redirect', 'github'))
            ->assertStatus(200)
            ->assertJson(['url' => 'https://url-to-provider']);
    }

    /** @test */
    public function it_can_create_new_user_from_github_identity()
    {
        $github_identity = [
            'id' => '123',
            'name' => 'New GitHub User',
            'email' => 'new-github@example.com',
            'token' => 'access-token',
            'refreshToken' => 'refresh-token',
        ];

        $this->mockSocialite('github', $github_identity);

        $this->withoutExceptionHandling();

        $this->get(route('oauth.callback', 'github'))
            ->assertText('user')
            ->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'name' => $github_identity['name'],
            'email' => $github_identity['email'],
        ]);

        $userId = User::query()->firstWhere('email', $github_identity['email'])->id;

        $this->assertDatabaseHas('oauth_providers', [
            'user_id' => $userId,
            'provider' => 'github',
            'provider_user_id' => $github_identity['id'],
            'access_token' => $github_identity['token'],
            'refresh_token' => $github_identity['refreshToken'],
        ]);

        $providerCount = OAuthProvider::query()->where('user_id', $userId)->where('provider', 'github')->count();

        $this->assertEquals($providerCount, 1);
    }

    /** @test */
    public function it_can_update_github_identity_for_existing_user()
    {
        $existing_user = $this->user();

        $existing_user->oauthProviders()->updateOrCreate(['user_id' => $existing_user->id], [
            'provider' => 'github',
            'provider_user_id' => '123',
            'access_token' => 'access-token',
            'refresh_token' => 'refresh-token',
        ]);

        $updated_github_identity = [
            'id' => '123',
            'name' => 'Updated GitHub User',
            'email' => $existing_user->email,
            'token' => 'updated-access-token',
            'refreshToken' => 'updated-refresh-token',
        ];

        $this->mockSocialite('github', $updated_github_identity);

        $this->withoutExceptionHandling();

        $this->get(route('oauth.callback', 'github'))
            ->assertText('user')
            ->assertSuccessful();

        $this->assertDatabaseHas('oauth_providers', [
            'user_id' => $existing_user->id,
            'provider' => 'github',
            'access_token' => $updated_github_identity['token'],
            'refresh_token' => $updated_github_identity['refreshToken'],
        ]);

        $providerCount = OAuthProvider::query()->where('user_id', $existing_user->id)->where('provider', 'github')->count();

        $this->assertEquals($providerCount, 1);
    }

    /** @test */
    public function it_can_add_github_identity_to_existing_user()
    {
        $existing_user = $this->user();

        $this->assertEquals($existing_user->oauthProviders->count(), 0);

        $github_identity = [
            'id' => '123',
            'name' => 'New GitHub User',
            'email' => $existing_user->email,
            'token' => 'access-token',
            'refreshToken' => 'refresh-token',
        ];

        $this->mockSocialite('github', $github_identity);

        $this->withoutExceptionHandling();

        $this->get(route('oauth.callback', 'github'))
            ->assertText('user')
            ->assertSuccessful();

        $this->assertDatabaseHas('oauth_providers', [
            'user_id' => $existing_user->id,
            'provider' => 'github',
            'provider_user_id' => $github_identity['id'],
            'access_token' => $github_identity['token'],
            'refresh_token' => $github_identity['refreshToken'],
        ]);

        $providerCount = OAuthProvider::query()->where('user_id', $existing_user->id)->where('provider', 'github')->count();

        $this->assertEquals($providerCount, 1);
    }

}
