<?php

namespace App\Helpers;

trait SocialRequest
{
    /**
     * @var
     */
    private $fb;

    /**
     * SocialContractImpl constructor.
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function __construct()
    {
        $this->fb = new \Facebook\Facebook([
            'app_id' => env('FACEBOOK_KEY'),
            'app_secret' => env('FACEBOOK_SECRET'),
            'default_graph_version' => 'v2.5',
        ]);

        $this->initializeTwitterOAuth('twitter');
    }
}