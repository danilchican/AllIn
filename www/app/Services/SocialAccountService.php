<?php

namespace App\Services;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Contracts\SocialContract;
use App\Helpers\TwitterAuth;
use App\UserSocialAccount;
use App\User;
use Illuminate\Http\Request;

class SocialAccountService
{
    use TwitterAuth;

    /**
     * @var SocialContract
     */
    private $client;

    /**
     * SocialAccountService constructor.
     * @param SocialContract $client
     */
    public function __construct(SocialContract $client)
    {
        $this->client = $client;
    }

    /**
     * Create or get user.
     *
     * @param $providerObj
     * @param $providerName
     * @return mixed
     */
    public function createOrGetUser($providerObj, $providerName)
    {
        $providerUser = $providerObj->user();
        $isNewUser = false;

        $account = UserSocialAccount::whereProvider($providerName)
            ->whereProviderUserId($providerUser->getId())
            ->first();


        if ($account) {
            $token = $this->client->getAccessToken($providerName, $providerUser);
            $upFields = ['access_token' => $token];

            if ($providerName === 'twitter') {
                $upFields['access_token_secret'] = $providerUser->tokenSecret;
            }

            $account->update($upFields);

            return [
                'user' => $account->user,
                'isNewUser' => $isNewUser
            ];
        } else {
            $avatar = $this->client->getUserAvatarByProvider($providerName, $providerUser);
            $token = $this->client->getAccessToken($providerName, $providerUser);

            $fields = [
                'access_token' => $token,
                'provider' => $providerName,
                'provider_user_id' => $providerUser->getId()
            ];

            if ($providerName === 'twitter') {
                $fields['access_token_secret'] = $providerUser->tokenSecret;
            }

            $account = new UserSocialAccount($fields);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {
                $isNewUser = true;
                $user = User::createBySocialProvider($providerUser, $avatar);
            }

            if ($user->avatar === null) {
                $user->avatar = $avatar;
                $user->save();
            }

            $account->user()->associate($user);
            $account->save();

            return [
                'user' => $user,
                'isNewUser' => $isNewUser
            ];
        }
    }

    /**
     * Append social to user account.
     *
     * @param $providerObj
     * @param $providerName
     * @return array
     */
    public function appendSocialAccount($providerObj, $providerName)
    {
        $providerUser = $providerObj->user();

        $account = UserSocialAccount::whereProvider($providerName)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        $existAccount = false;

        if ($account) {
            $token = $this->client->getAccessToken($providerName, $providerUser);
            $account->update(['access_token' => $token]);

            $existAccount = true;

            return [
                'existAccount' => $existAccount
            ];
        } else {
            $token = $this->client->getAccessToken($providerName, $providerUser);

            $account = new UserSocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $providerName,
                'access_token' => $token]);

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
     * Own twitter driver.
     *
     * @param $provider
     * @param Request $request
     * @return $this
     * @throws \RuntimeException
     * @throws \Abraham\TwitterOAuth\TwitterOAuthException
     */
    public function twitterDriver($provider, Request $request)
    {
        $this->twitter_callback_url = env('APP_URL') . '/socials/' . $provider . '/callback';

        $this->twitter_connection = new TwitterOAuth(env('TWITTER_KEY'), env('TWITTER_SECRET'));

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