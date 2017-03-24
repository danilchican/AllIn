<?php

namespace App\Helpers;


trait TwitterAuth
{
    /**
     * @var string
     */
    private $twitter_callback_url;

    /**
     * @var array
     */
    private $twitter_connection;

    /**
     * @var \Abraham\TwitterOAuth\TwitterOAuth request
     */
    private $twitter_request;
}