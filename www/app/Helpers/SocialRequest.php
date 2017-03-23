<?php

namespace App\Helpers;

trait SocialRequest
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