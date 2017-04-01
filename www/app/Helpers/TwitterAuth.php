<?php

namespace App\Helpers;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\UserSocialAccount;
use Illuminate\Http\Request;

trait TwitterAuth
{
    /**
     * @var string
     */
    private $twitter_callback_url;

    /**
     * @var array
     */
    private $twitter_connection;

    /**
     * @var \Abraham\TwitterOAuth\TwitterOAuth request
     */
    private $twitter_request;

    /**
     * @var
     */
    private $twitter_provider;

    /**
     * Initialize TwitterOAuth object.
     *
     * @param $provider
     */
    public function initializeTwitterOAuth($provider)
    {
        $this->twitter_provider = $provider;
        $this->twitter_callback_url = env('APP_URL') . '/socials/' . $provider . '/callback';
        $this->twitter_connection = new TwitterOAuth(env('TWITTER_KEY'), env('TWITTER_SECRET'));
    }

    /**
     * Own twitter driver.
     *
     * @param Request $request
     * @return $this
     * @throws \RuntimeException
     * @throws \Abraham\TwitterOAuth\TwitterOAuthException
     */
    public function twitterDriver(Request $request)
    {
        $this->twitter_request = $this->twitter_connection
            ->oauth('oauth/request_token',
                ['oauth_callback' => $this->twitter_callback_url]
            );

        $request->session()
            ->put('oauth_token', $this->twitter_request['oauth_token']);

        $request->session()
            ->put('oauth_token_secret', $this->twitter_request['oauth_token_secret']);

        $this->twitter_callback_url = $this->twitter_connection
            ->url('oauth/authorize',
                ['oauth_token' => $this->twitter_request['oauth_token']]
            );

        return $this;
    }

    /**
     *
     *
     * @param Request $request
     * @return string
     * @throws \RuntimeException
     */
    public function appendTwitter(Request $request)
    {
        $request_token = [];
        $request_token['oauth_token'] = $request->session()->get('oauth_token');
        $request_token['oauth_token_secret'] = $request->session()->get('oauth_token_secret');

        if ($request->has('oauth_token') && ($request_token['oauth_token'] !== $request->get('oauth_token'))) {
            throw new \RuntimeException();
        }

        $this->twitter_connection
            ->setOauthToken($request_token['oauth_token'], $request_token['oauth_token_secret']);

        $user = $this->twitter_connection
            ->oauth('oauth/access_token',
                ['oauth_verifier' => $request->get('oauth_verifier')]
            );

        return $this->append($user);
    }

    /**
     * Append twitter account.
     *
     * @param $user
     * @return array
     */
    private function append($user)
    {
        $account = UserSocialAccount::whereProvider($this->twitter_provider)
            ->whereProviderUserId($user['user_id'])
            ->first();

        $existAccount = false;

        if ($account) {
            $account->update([
                'access_token' => $user['oauth_token'],
                'access_token_secret' => $user['oauth_token_secret'],
            ]);

            $existAccount = true;

            return [
                'existAccount' => $existAccount
            ];
        } else {
            $account = new UserSocialAccount([
                'provider_user_id' => $user['user_id'],
                'provider' => $this->twitter_provider,
                'access_token' => $user['oauth_token'],
                'access_token_secret' => $user['oauth_token_secret'],
            ]);

            $user = \Auth::user();

            if ($user) {
                $user->socials()->save($account);
            }

            return [
                'existAccount' => $existAccount
            ];
        }
    }

    /**
     * Redirect to callback twitter url.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function redirect()
    {
        return redirect($this->twitter_callback_url);
    }

}