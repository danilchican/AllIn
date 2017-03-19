<?php

namespace App\Helpers;

interface SocialContract
{
    public function getUserAvatarByProvider($providerName, $providerUser);
}