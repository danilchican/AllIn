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
            $isNewUser = true;
            $account = new UserSocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $providerName]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {
                $user = User::createBySocialProvider($providerUser);
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
}