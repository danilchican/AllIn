<?php

namespace App\Helpers;

use Abraham\TwitterOAuth\TwitterOAuth;
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
     * Initialize TwitterOAuth object.
     *
     * @param $provider
     */
    public function initializeTwitterOAuth($provider)
    {
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
     * Redirect to callback twitter url.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function redirect()
    {
        return redirect($this->twitter_callback_url);
    }
}