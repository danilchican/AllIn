<?php

namespace App\Helpers;

interface SocialContract
{
    public function getUserAvatarByProvider($providerName, $providerUser);
    public function getVkontakteAvatar($providerUser);
    public function getFacebookAvatar($providerUser);

    public function request($client, $request, $method = 'GET');
}