<?php

namespace App\Services;

use App\Contracts\SocialAccountContract;
use App\Contracts\SocialContract;
use App\Helpers\SocialRequest;

class SocialService implements SocialContract, SocialAccountContract
{
    use SocialRequest;

    /**
     * Get the access token of the user.
     *
     * @param $providerName
     * @param $providerUser
     * @return null
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

    public function getTwitterAccessToken($providerUser)
    {
        return $providerUser->token;
    }

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
            case 'vkontakte':
                return $this->getVkontakteAvatar($providerUser);
            case 'facebook':
                return $this->getFacebookAvatar($providerUser);
            default:
                return null;
        }
    }

    /**
     * Get the VK avatar of the user.
     *
     * @param $providerUser
     * @return string
     */
    public function getVkontakteAvatar($providerUser)
    {
        $userID = $providerUser->getId();
        $token = $providerUser->token;

        $fields = ['photo_400_orig'];

        $request = '/method/users.get?user_id='.$userID
                    .'&v='.self::VK_API_VER
                    .'&fields='.implode(',', $fields)
                    .'&access_token='.$token;

        $response = $this->request(self::VK_API_CLIENT, $request);

        $result = json_decode($response->getBody());

        if(isset($result->response[0]->photo_400_orig)) {
            return $result->response[0]->photo_400_orig;
        }

        return null;
    }

    /**
     * Get the FB avatar of the user.
     *
     * @param $providerUser
     * @return mixed
     */
    public function getFacebookAvatar($providerUser)
    {
        return $providerUser->getAvatar();
    }

}