<?php

namespace App\Services;

use App\Contracts\SocialContract;
use App\Helpers\TwitterAuth;
use App\UserSocialAccount;
use App\User;

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
        $this->initializeTwitterOAuth('twitter');
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

}