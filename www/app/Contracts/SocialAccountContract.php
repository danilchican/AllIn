<?php

namespace App\Contracts;


interface SocialAccountContract
{
    public function getUserAvatarByProvider($providerName, $providerUser);
    public function getVkontakteAvatar($providerUser);
    public function getFacebookAvatar($providerUser);
    public function getTwitterAvatar($providerUser);
}