<?php

namespace App\Helpers;

interface SocialContract
{
    public function getUserAvatarByProvider($providerName, $providerUser);
    public function getVkontakteAvatar($providerUser);
    public function getFacebookAvatar($providerUser);
}