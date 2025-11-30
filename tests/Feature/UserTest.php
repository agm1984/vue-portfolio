<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_can_get_authenticated_user_profile()
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $this->actingAs($user)
            ->getJson(route('me'))
            ->assertStatus(200)
            ->assertJson([
                'id' => $user->id,
                'email' => 'john@example.com',
                'name' => 'John Doe',
            ]);
    }

    #[Test]
    public function it_can_update_user_profile()
    {
        $user = User::factory()->create([
            'name' => 'Original Name',
            'email' => 'original@example.com',
        ]);

        $this->actingAs($user)
            ->postJson(route('user.profile.edit'), [
                'name' => 'Updated Name',
                'email' => 'updated@example.com',
            ])
            ->assertStatus(200)
            ->assertJson([
                'user' => [
                    'name' => 'Updated Name',
                    'email' => 'updated@example.com',
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }

    #[Test]
    public function it_can_get_linked_oauth_providers()
    {
        $user = User::factory()->create();

        $user->oauthProviders()->create([
            'provider' => 'github',
            'provider_user_id' => '123456',
            'access_token' => 'github-token',
            'refresh_token' => 'github-refresh',
        ]);

        $user->oauthProviders()->create([
            'provider' => 'twitter',
            'provider_user_id' => '789012',
            'access_token' => 'twitter-token',
            'refresh_token' => null,
        ]);

        $this->actingAs($user)
            ->getJson(route('user.oauth.providers'))
            ->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJsonFragment(['provider' => 'github'])
            ->assertJsonFragment(['provider' => 'twitter']);
    }

    #[Test]
    public function it_can_update_password_with_correct_old_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        $this->actingAs($user)
            ->putJson(route('user.password.edit'), [
                'old_password' => 'old-password',
                'new_password' => 'new-password',
            ])
            ->assertStatus(200)
            ->assertJsonStructure(['user']);

        // Verify new password works
        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }

    #[Test]
    public function it_rejects_password_update_with_incorrect_old_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('correct-password'),
        ]);

        $this->actingAs($user)
            ->putJson(route('user.password.edit'), [
                'old_password' => 'wrong-password',
                'new_password' => 'new-password',
            ])
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'old_password' => ['Password is incorrect.'],
                ],
            ]);

        // Verify password wasn't changed
        $this->assertTrue(Hash::check('correct-password', $user->fresh()->password));
    }
}
