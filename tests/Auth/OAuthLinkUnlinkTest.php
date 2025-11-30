<?php

namespace Tests\Auth;

use App\Http\Controllers\Auth\TwitterClient;
use App\Models\OAuthProvider;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery as m;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class OAuthLinkUnlinkTest extends TestCase
{
    use DatabaseTransactions;

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
            $mock->shouldReceive('with')
                ->andReturn(m::self())
                ->shouldReceive('redirect')
                ->andReturn(redirect('https://url-to-provider'));
        }
    }

    protected function mockTwitterOAuth(?array $user = null)
    {
        $mock = $this->mock(TwitterClient::class);
        $mock->shouldReceive('getUrl')->andReturn('https://url-to-provider');

        if ($user) {
            $mock->shouldReceive('getUser')->andReturn($user);
        }
    }

    public function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }

    // ==================== Link Provider Tests ====================

    #[Test]
    public function it_requires_authentication_to_link_provider()
    {
        $this->postJson(route('oauth.link', 'github'))
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    #[Test]
    public function it_validates_supported_providers_when_linking()
    {
        $user = $this->user();

        $this->actingAs($user)
            ->postJson(route('oauth.link', 'unsupported-provider'))
            ->assertStatus(400)
            ->assertJson(['error' => 'Unsupported OAuth provider.']);
    }

    #[Test]
    public function it_generates_state_token_for_github_link()
    {
        $user = $this->user();
        $this->mockSocialite('github');

        $response = $this->actingAs($user)
            ->postJson(route('oauth.link', 'github'))
            ->assertStatus(200)
            ->assertJsonStructure(['url']);

        // Verify state was stored in session
        $this->assertNotNull(session('oauth_link_state'));
        $this->assertEquals(40, strlen(session('oauth_link_state')));
    }

    #[Test]
    public function it_returns_oauth_url_for_linking()
    {
        $user = $this->user();
        $this->mockSocialite('github');

        $this->actingAs($user)
            ->postJson(route('oauth.link', 'github'))
            ->assertStatus(200)
            ->assertJson(['url' => 'https://url-to-provider']);
    }

    #[Test]
    public function it_validates_state_parameter_on_link_callback()
    {
        $user = $this->user();

        $github_identity = [
            'id' => '123',
            'name' => 'GitHub User',
            'email' => $user->email,
            'token' => 'access-token',
            'refreshToken' => 'refresh-token',
        ];

        $this->mockSocialite('github', $github_identity);

        // Set invalid state in session
        session(['oauth_link_state' => 'valid-state']);

        $this->actingAs($user)
            ->get(route('oauth.link.callback', 'github') . '?state=invalid-state')
            ->assertSuccessful()
            ->assertSee('Invalid state parameter');
    }

    #[Test]
    public function it_prevents_linking_provider_already_linked_to_another_user()
    {
        $user1 = $this->user();
        $user2 = User::factory()->create();

        // Link GitHub to user1
        $user1->oauthProviders()->create([
            'provider' => 'github',
            'provider_user_id' => '123',
            'access_token' => 'token1',
            'refresh_token' => null,
        ]);

        $github_identity = [
            'id' => '123', // Same provider_user_id as user1
            'name' => 'GitHub User',
            'email' => $user2->email,
            'token' => 'token2',
            'refreshToken' => 'refresh-token2',
        ];

        $this->mockSocialite('github', $github_identity);

        session(['oauth_link_state' => 'test-state']);

        $this->actingAs($user2)
            ->get(route('oauth.link.callback', 'github') . '?state=test-state')
            ->assertSuccessful()
            ->assertSee('already linked to another user');
    }

    #[Test]
    public function it_successfully_links_github_provider()
    {
        $user = $this->user();

        $github_identity = [
            'id' => '456',
            'name' => 'GitHub User',
            'email' => $user->email,
            'token' => 'access-token',
            'refreshToken' => 'refresh-token',
        ];

        $this->mockSocialite('github', $github_identity);

        session(['oauth_link_state' => 'test-state']);

        $this->actingAs($user)
            ->get(route('oauth.link.callback', 'github') . '?state=test-state')
            ->assertSuccessful()
            ->assertSee('user');

        $this->assertDatabaseHas('oauth_providers', [
            'user_id' => $user->id,
            'provider' => 'github',
            'provider_user_id' => '456',
            'access_token' => 'access-token',
        ]);
    }

    #[Test]
    public function it_generates_url_for_twitter_link_without_state()
    {
        $user = $this->user();
        $this->mockTwitterOAuth();

        $response = $this->actingAs($user)
            ->postJson(route('oauth.link', 'twitter'))
            ->assertStatus(200)
            ->assertJsonStructure(['url']);

        // Twitter uses OAuth 1.0a, so no state parameter is stored
        // State is only for OAuth 2.0 providers
        $this->assertNotNull(session('oauth_link_state'));
    }

    #[Test]
    public function it_successfully_links_twitter_provider()
    {
        $user = $this->user();

        $twitter_identity = [
            'id' => '789',
            'name' => 'Twitter User',
            'email' => $user->email,
            'token' => 'twitter-access-token',
            'refreshToken' => null,
        ];

        $this->mockTwitterOAuth($twitter_identity);

        // Twitter doesn't use state parameter (OAuth 1.0a)
        $this->actingAs($user)
            ->get(route('oauth.link.callback', 'twitter'))
            ->assertSuccessful()
            ->assertSee('user');

        $this->assertDatabaseHas('oauth_providers', [
            'user_id' => $user->id,
            'provider' => 'twitter',
            'provider_user_id' => '789',
            'access_token' => 'twitter-access-token',
        ]);
    }

    // ==================== Unlink Provider Tests ====================

    #[Test]
    public function it_requires_authentication_to_unlink_provider()
    {
        $this->deleteJson(route('oauth.unlink', 'github'))
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    #[Test]
    public function it_validates_supported_providers_when_unlinking()
    {
        $user = $this->user();

        $this->actingAs($user)
            ->deleteJson(route('oauth.unlink', 'unsupported-provider'))
            ->assertStatus(400)
            ->assertJson(['error' => 'Unsupported OAuth provider.']);
    }

    #[Test]
    public function it_returns_404_if_provider_not_linked()
    {
        $user = $this->user();

        $this->actingAs($user)
            ->deleteJson(route('oauth.unlink', 'github'))
            ->assertStatus(404)
            ->assertJson(['error' => 'Provider not linked.']);
    }

    #[Test]
    public function it_prevents_unlinking_only_login_method()
    {
        // Create user without password (OAuth only)
        $user = User::factory()->create(['password' => null]);

        // Link only one provider
        $user->oauthProviders()->create([
            'provider' => 'github',
            'provider_user_id' => '123',
            'access_token' => 'token',
            'refresh_token' => null,
        ]);

        $this->actingAs($user)
            ->deleteJson(route('oauth.unlink', 'github'))
            ->assertStatus(400)
            ->assertJson(['error' => 'You cannot unlink your only login method. Please set a password or link another provider first.']);

        // Verify provider was NOT deleted
        $this->assertDatabaseHas('oauth_providers', [
            'user_id' => $user->id,
            'provider' => 'github',
        ]);
    }

    #[Test]
    public function it_allows_unlinking_when_password_exists()
    {
        $user = $this->user(); // Has password

        // Link GitHub
        $user->oauthProviders()->create([
            'provider' => 'github',
            'provider_user_id' => '123',
            'access_token' => 'token',
            'refresh_token' => null,
        ]);

        $this->actingAs($user)
            ->deleteJson(route('oauth.unlink', 'github'))
            ->assertStatus(200)
            ->assertJson(['message' => 'Provider unlinked successfully.']);

        // Verify provider was deleted
        $this->assertDatabaseMissing('oauth_providers', [
            'user_id' => $user->id,
            'provider' => 'github',
        ]);
    }

    #[Test]
    public function it_allows_unlinking_when_multiple_providers_exist()
    {
        // Create user without password
        $user = User::factory()->create(['password' => null]);

        // Link two providers
        $user->oauthProviders()->create([
            'provider' => 'github',
            'provider_user_id' => '123',
            'access_token' => 'token1',
            'refresh_token' => null,
        ]);

        $user->oauthProviders()->create([
            'provider' => 'twitter',
            'provider_user_id' => '456',
            'access_token' => 'token2',
            'refresh_token' => null,
        ]);

        $this->actingAs($user)
            ->deleteJson(route('oauth.unlink', 'github'))
            ->assertStatus(200)
            ->assertJson(['message' => 'Provider unlinked successfully.']);

        // Verify GitHub was deleted but Twitter remains
        $this->assertDatabaseMissing('oauth_providers', [
            'user_id' => $user->id,
            'provider' => 'github',
        ]);

        $this->assertDatabaseHas('oauth_providers', [
            'user_id' => $user->id,
            'provider' => 'twitter',
        ]);
    }

    #[Test]
    public function it_successfully_unlinks_provider()
    {
        $user = $this->user();

        $provider = $user->oauthProviders()->create([
            'provider' => 'github',
            'provider_user_id' => '123',
            'access_token' => 'token',
            'refresh_token' => null,
        ]);

        $this->assertEquals(1, $user->oauthProviders()->count());

        $this->actingAs($user)
            ->deleteJson(route('oauth.unlink', 'github'))
            ->assertStatus(200)
            ->assertJson(['message' => 'Provider unlinked successfully.']);

        $this->assertEquals(0, $user->fresh()->oauthProviders()->count());
    }
}
