<?php

namespace App\Services;

use App\Contracts\SocialAccountContract;
use App\Contracts\SocialContract;
use App\Helpers\SocialRequest;

class SocialService implements SocialContract, SocialAccountContract
{
    use SocialRequest;

    /**
     * Get the access token for the provider name.
     *
     * @param $providerName
     * @param $providerUser
     * @return null
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function getAccessToken($providerName, $providerUser)
    {
        switch ($providerName) {
            case 'facebook':
                return $this->getFacebookAccessToken($providerUser);
            case 'twitter':
                return $this->getTwitterAccessToken($providerUser);
            default:
                return null;
        }
    }

    /**
     * Get the Twitter access token for the provider name.
     *
     * @param $providerUser
     * @return mixed
     */
    public function getTwitterAccessToken($providerUser)
    {
        return $providerUser->token;
    }

    /**
     * Get the Facebook access token for the provider name.
     *
     * @param $providerUser
     * @return \Facebook\Authentication\AccessToken
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function getFacebookAccessToken($providerUser)
    {
        $oAuth2Client = $this->fb->getOAuth2Client();

        return $oAuth2Client->getLongLivedAccessToken($providerUser->token);
    }

    /**
     * Get the avatar of the user.
     *
     * @param $providerName
     * @param $providerUser
     * @return null|string
     */
    public function getUserAvatarByProvider($providerName, $providerUser)
    {
        switch ($providerName) {
            case 'facebook':
                return $this->getFacebookAvatar($providerUser);
            case 'twitter':
                return $this->getTwitterAvatar($providerUser);
            default:
                return null;
        }
    }

    /**
     * Get the Facebook avatar of the user.
     *
     * @param $providerUser
     * @return mixed
     */
    public function getFacebookAvatar($providerUser)
    {
        return $providerUser->getAvatar();
    }

    /**
     * Get the Twitter avatar of the user.
     *
     * @param $providerUser
     * @return mixed
     */
    public function getTwitterAvatar($providerUser)
    {
        return $providerUser->avatar;
    }

}