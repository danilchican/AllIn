<?php

namespace App\Services;

use App\Contracts\PostContract;
use App\Contracts\SocialContract;
use App\Helpers\SocialRequest;
use App\Helpers\TwitterAuth;
use App\Post;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

class PostService implements SocialContract, PostContract
{
    use TwitterAuth;
    use SocialRequest;

    /**
     * Send post to all entered providers.
     *
     * @param Post $post
     * @param array $providers
     * @param $user
     * @return \Facebook\GraphNodes\GraphNode|mixed|null|string
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function send(Post $post, $providers = [], $user)
    {
        $responses = [];

        $listProviders = $user->socials()->where(function ($query) use ($providers) {
            foreach($providers as $provider) {
                $query->orWhere('id', '=', $provider['id']);
            }
        })->get();

        foreach ($listProviders as $provider) {
            $providerName = $provider['provider'];

            switch ($providerName) {
                case 'facebook':
                    $responses[$providerName] = $this->sendFacebookPost($post, $user, $provider);
                    break;
                case 'twitter':
                    $responses[$providerName] = $this->sendTwitterPost($post, $user, $provider);
                    break;
                default:
                    break;
            }
        }

        return $responses;
    }

    /**
     * Post to feed new post.
     *
     * @param Post $post
     * @param $user
     * @param $provider
     * @return \Facebook\GraphNodes\GraphNode|string
     * @throws FacebookSDKException
     */
    public function sendFacebookPost(Post $post, $user, $provider)
    {
        $data = [
            'message' => $post->getBody()
        ];


        try {
            $response = $this->fb->post('/me/feed', $data, $provider->getToken());
        } catch(FacebookResponseException $e) {
            return 'Graph returned an error: ' . $e->getMessage();
        } catch(FacebookSDKException $e) {
            return 'Facebook SDK returned an error: ' . $e->getMessage();
        }

        return $response->getGraphNode();
    }

    /**
     * Post new tweet.
     *
     * @param Post $post
     * @param $user
     * @param $provider
     * @return mixed
     */
    public function sendTwitterPost(Post $post, $user, $provider)
    {
        $this->twitter_connection->setOauthToken($provider->getToken(), $provider->getSecretToken());

        return $this->twitter_connection->post('statuses/update', ['status' => $post->getBody()]);
    }
}