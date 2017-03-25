<?php

namespace App\Contracts;

interface SocialContract
{
    const FB_API_CLIENT = 'https://graph.facebook.com';

    const GET_METHOD = 'GET';
    const POST_METHOD = 'POST';

    public function request($client, $request, $method = 'GET');
}