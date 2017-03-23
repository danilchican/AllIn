<?php

namespace App\Contracts;

interface SocialContract
{
    const VK_API_CLIENT = 'https://api.vk.com';
    const FB_API_CLIENT = 'https://graph.facebook.com';

    const GET_METHOD = 'GET';
    const POST_METHOD = 'POST';

    const VK_API_VER = '5.37';

    public function request($client, $request, $method = 'GET');
}