<?php

namespace App\Services;

use App\Contracts\SocialAccountContract;
use App\Contracts\SocialContract;

class SocialService implements SocialContract, SocialAccountContract
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * SocialContractImpl constructor.
     */
    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
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

    /**
     * Create a new request to client.
     *
     * @param $client
     * @param $request
     * @param string $method
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function request($client, $request, $method = 'GET')
    {
        return $this->client->request($method, $client.$request);
    }
}