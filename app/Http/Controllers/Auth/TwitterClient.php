<?php

namespace App\Http\Controllers\Auth;

use Abraham\TwitterOAuth\TwitterOAuth;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TwitterClient {
    /**
     * Get the callback URL for Twitter OAuth.
     *
     * @return void
     */
    public static function getUrl()
    {
        $tempId = Str::random(40);

        $connection = new TwitterOAuth(config('services.twitter.client_id'), config('services.twitter.client_secret'));
        $requestToken = $connection->oauth('oauth/request_token', array('oauth_callback' => config('services.twitter.callback_url').'?user='.$tempId));

        Cache::put($tempId, $requestToken['oauth_token_secret'], 86400); // 86400 seconds = 1 day

        $url = $connection->url('oauth/authorize', array('oauth_token' => $requestToken['oauth_token']));

        return $url;
    }

    /**
     * Get the Twitter identity for the user.
     *
     * @param \Illuminate\Http\Request $request
     * @return object
     */
    public static function getUser(Request $request)
    {
        $connection = new TwitterOAuth(config('services.twitter.client_id'), config('services.twitter.client_secret'), $request->oauth_token, Cache::get($request->user));
        $access_token = $connection->oauth('oauth/access_token', ['oauth_verifier' => $request->oauth_verifier]);

        $connection = new TwitterOAuth(config('services.twitter.client_id'), config('services.twitter.client_secret'), $access_token['oauth_token'], $access_token['oauth_token_secret']);
        $user = $connection->get('account/verify_credentials', ['include_email' => 'true']);

        $user->token = $access_token['oauth_token'];

        return (object)$user;
    }
}
