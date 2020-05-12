<?php

namespace App\Http\Controllers\Auth;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Exceptions\EmailTakenException;
use App\Http\Controllers\Controller;
use App\OAuthProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        config([
            'services.github.redirect' => route('oauth.callback', 'github'),
        ]);
    }

    /**
     * Redirect the user to the provider authentication page. Twitter uses OAuth1.0a, and does not support
     * Socialite::driver($provider)->stateless(), so library `abraham/twitteroauth` is used to handle everything.
     *
     * @param  string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        if ($provider === 'twitter') {
            $tempId = Str::random(40);

            $connection = new TwitterOAuth(config('services.twitter.client_id'), config('services.twitter.client_secret'));
            $requestToken = $connection->oauth('oauth/request_token', array('oauth_callback' => config('services.twitter.callback_url').'?user='.$tempId));

            \Cache::put($tempId, $requestToken['oauth_token_secret'], 86400); // 86400 seconds = 1 day

            $url = $connection->url('oauth/authorize', array('oauth_token' => $requestToken['oauth_token']));
        } else {
            $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
        }

        return [
            'url' => $url,
        ];
    }

    /**
     * Obtain the user information from the provider.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $driver
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request, $provider)
    {
        if ($provider === 'twitter') {
            $connection = new TwitterOAuth(config('services.twitter.client_id'), config('services.twitter.client_secret'), $request->oauth_token, \Cache::get($request->user));
            $access_token = $connection->oauth('oauth/access_token', ['oauth_verifier' => $request->oauth_verifier]);

            $connection = new TwitterOAuth(config('services.twitter.client_id'), config('services.twitter.client_secret'), $access_token['oauth_token'], $access_token['oauth_token_secret']);
            $user = $connection->get('account/verify_credentials', ['include_email' => 'true']);

            $user->token = $access_token['oauth_token'];
        } else {
            $user = Socialite::driver($provider)->stateless()->user();
        }

        $user = $this->findOrCreateUser($provider, $user);

        $this->guard()->setToken(
            $token = $this->guard()->login($user)
        );

        return view('oauth/callback', [
            'user' => $user,
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->getPayload()->get('exp') - time(),
        ]);
    }

    /**
     * When the oauth provider calls back, update provider's access token.
     *
     * @param string $provider
     * @param \Laravel\Socialite\Contracts\User $sUser
     * @return \App\User|false
     */
    protected function findOrCreateUser($provider, $sUser)
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
            $user = User::create([
                'name' => $sUser->name,
                'email' => $sUser->email,
                'email_verified_at' => now(),
            ]);
        }

        // if the user registered via email/password but didn't verify their email yet,
        // we can mark it as verified because oauth provider already validated their email.
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
     * @param \Laravel\Socialite\Contracts\User $sUser
     * @param \App\User $user
     * @return \App\User
     */
    protected function addProvider($provider, $sUser, User $user)
    {
        $user->oauthProviders()->create([
            'provider' => $provider,
            'provider_user_id' => $sUser->id,
            'access_token' => $sUser->token,
            'refresh_token' => $sUser->refreshToken ?? null,
        ]);

        return $user;
    }

}
