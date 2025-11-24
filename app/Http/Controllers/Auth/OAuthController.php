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
        if ($provider === 'twitter') {
            $socialIdentity = (object)$this->twitterApi->getUser($request);
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
    protected function findOrCreateUser($provider, $sUser) : User
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
    protected function addProvider($provider, $sUser, User $user) : User
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

}
