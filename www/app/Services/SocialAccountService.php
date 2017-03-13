<?php

namespace App\Services;

use App\UserSocialAccount;
use App\User;

class SocialAccountService
{

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
            return [
                'user' => $account->user,
                'isNewUser' => $isNewUser
            ];
        } else {
            $avatar = $this->getUserAvatar($providerName, $providerUser);

            $account = new UserSocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'access_token' => $providerUser->token,
                'provider' => $providerName]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {
                $isNewUser = true;
                $user = User::createBySocialProvider($providerUser, $avatar);
            }

            if($user->avatar === null) {
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
            $existAccount = true;

            return [
                'existAccount' => $existAccount
            ];
        } else {

            $account = new UserSocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $providerName]);

            $user = \Auth::user();

            if($user) {
                $user->socials()->save($account);
            }

            return [
                'existAccount' => $existAccount
            ];
        }
    }

    /**
     * Get user avatar.
     *
     * @param $providerName
     * @param $providerUser
     * @return null
     */
    public function getUserAvatar($providerName, $providerUser)
    {
        if($providerName === 'vkontakte') {
            $client = new \GuzzleHttp\Client();
            $request = $client->request('GET',
                'https://api.vk.com/method/users.get?user_id='
                .$providerUser->getId()
                .'&v=5.37&fields=photo_400_orig&access_token='
                .$providerUser->token);

            $result = json_decode($request->getBody());
            return $result->response[0]->photo_400_orig;
        } else {
            return $providerUser->getAvatar();
        }

        return null;
    }
}