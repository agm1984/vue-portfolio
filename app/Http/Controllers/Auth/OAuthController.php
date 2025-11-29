<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OAuthProvider;
use App\Models\User;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\TwitterClient;

class OAuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * @var TwitterClient
     */
    protected $twitterApi;

    /**
     * Create a new OAuth controller instance.
     *
     * @return void
     */
    public function __construct(TwitterClient $twitterApi)
    {
        config([
            'services.github.redirect' => route('oauth.callback', 'github'),
        ]);

        $this->twitterApi = $twitterApi; // TwitterClient is injected for unit test mocking
    }

    /**
     * Redirect the user to the provider authentication page. Twitter uses OAuth1.0a, and does not support
     * Socialite::driver($provider)->stateless(), so library `abraham/twitteroauth` is used to handle that case.
     *
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        if ($provider === 'twitter') {
            $url = $this->twitterApi->getUrl();
        } else {
            $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
        }

        return [
            'url' => $url,
        ];
    }

    /**
     * Obtain the user information from the provider. `$socialIdentity` must be an Object due to
     * downstream accessors.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $driver
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request, $provider)
    {
        if (Auth::check()) {
            return $this->handleLinkCallback($request, $provider);
        }

        if ($provider === 'twitter') {
            $socialIdentity = (object) $this->twitterApi->getUser($request);
        } else {
            $socialIdentity = Socialite::driver($provider)->stateless()->user();
        }

        $user = $this->findOrCreateUser($provider, $socialIdentity);

        Auth::login($user);

        return view('oauth/callback', [
            'user' => $user,
        ]);
    }

    /**
     * When the oauth provider calls back, update provider's access token.
     *
     * @param string $provider
     * @param \Laravel\Socialite\Contracts\User|object $sUser
     * @return \App\Models\User|false
     */
    protected function findOrCreateUser($provider, $sUser): User
    {
        $oauthProvider = OAuthProvider::where('provider', $provider)
            ->where('provider_user_id', $sUser->id)
            ->first();

        if ($oauthProvider) {
            $oauthProvider->update([
                'access_token' => $sUser->token,
                'refresh_token' => $sUser->refreshToken ?? null,
            ]);

            return $oauthProvider->user;
        }

        $user = User::firstWhere('email', $sUser->email);

        if (!$user) {
            $user = User::generate($sUser->name, $sUser->email, null);
        }

        // if the user registered via email/password but didn't verify their email yet,
        // we can mark it as verified via oauth provider trust.
        if ($user->email_verified_at === null) {
            $user->email_verified_at = now();
            $user->save();
        }

        return $this->addProvider($provider, $sUser, $user);
    }

    /**
     * Adds a new oauth provider to an existing user.
     *
     * @param string $provider
     * @param \Laravel\Socialite\Contracts\User|object $sUser
     * @param \App\Models\User $user
     * @return \App\Models\User
     */
    protected function addProvider($provider, $sUser, User $user): User
    {
        // TODO: function should update if entry already exists
        $user->oauthProviders()->updateOrCreate(['user_id' => $user->id], [
            'provider' => $provider,
            'provider_user_id' => $sUser->id,
            'access_token' => $sUser->token,
            'refresh_token' => $sUser->refreshToken ?? null,
        ]);

        return $user;
    }

    /**
     * Redirect the authenticated user to the provider authentication page for linking.
     *
     * @param string $provider
     * @return \Illuminate\Http\JsonResponse
     */
    public function linkProvider($provider)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if ($provider === 'twitter') {
            $url = $this->twitterApi->getUrl();
        } else {
            $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
        }

        return response()->json([
            'url' => $url,
        ]);
    }

    /**
     * Handle the OAuth callback for linking a provider to an authenticated user.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function handleLinkCallback(Request $request, $provider)
    {
        if (!Auth::check()) {
            return view('oauth/callback', [
                'error' => 'You must be logged in to link a provider.',
            ]);
        }

        if ($provider === 'twitter') {
            $socialIdentity = (object) $this->twitterApi->getUser($request);
        } else {
            $socialIdentity = Socialite::driver($provider)->stateless()->user();
        }

        $user = Auth::user();

        // Check if this provider is already linked to a different user
        $existingProvider = OAuthProvider::where('provider', $provider)
            ->where('provider_user_id', $socialIdentity->id)
            ->first();

        if ($existingProvider && $existingProvider->user_id !== $user->id) {
            return view('oauth/callback', [
                'error' => 'This ' . $provider . ' account is already linked to another user.',
            ]);
        }

        // Link the provider to the current user
        $this->addProvider($provider, $socialIdentity, $user);

        return view('oauth/callback', [
            'user' => $user->fresh(),
            'linked' => true,
        ]);
    }

    /**
     * Get the authenticated user's linked OAuth providers.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLinkedProviders()
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $providers = Auth::user()->oauthProviders()->get(['provider', 'created_at']);

        return response()->json($providers);
    }

    /**
     * Unlink an OAuth provider from the authenticated user.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $provider
     * @return \Illuminate\Http\JsonResponse
     */
    public function unlinkProvider(Request $request, $provider)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();

        // Check if the provider is actually linked
        $linkedProvider = $user->oauthProviders()->where('provider', $provider)->first();

        if (!$linkedProvider) {
            return response()->json(['error' => 'Provider not linked.'], 404);
        }

        // Safety check: Ensure user has at least one login method remaining
        $hasPassword = !empty($user->password);
        $linkedProvidersCount = $user->oauthProviders()->count();

        if (!$hasPassword && $linkedProvidersCount <= 1) {
            return response()->json([
                'error' => 'You cannot unlink your only login method. Please set a password or link another provider first.'
            ], 400);
        }

        $linkedProvider->delete();

        return response()->json(['message' => 'Provider unlinked successfully.']);
    }
}
