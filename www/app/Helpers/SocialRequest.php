<?php

namespace App\Helpers;

trait SocialRequest
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

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
        $this->client = new \GuzzleHttp\Client();

        $this->fb = new \Facebook\Facebook([
            'app_id' => env('FACEBOOK_KEY'),
            'app_secret' => env('FACEBOOK_SECRET'),
            'default_graph_version' => 'v2.5',
        ]);
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