<?php

namespace App\Services;

use App\Contracts\SocialContract;
use App\Contracts\StatisticContract;
use App\Helpers\SocialRequest;
use Facebook\Exceptions\FacebookSDKException;

class StatisticService implements SocialContract, StatisticContract
{
    use SocialRequest;

    private $user;
    private $socials;

    /**
     * Get the likes for each post.
     *
     * @param $posts
     * @param $user
     */
    public function getLikesForPosts($posts, $user)
    {
        $this->user = $user;
        $this->socials = $user->socials;

        $response = [];

        /** @var array $posts */
        foreach ($posts as $post) {
            $temp = [
                'likes' => $this->getLikes($post),
                'post' => $post->toArray()
            ];

            $postWithLikes[] = $temp;
        }

        return dd($postWithLikes);
    }

    /**
     * Get likes for current post.
     *
     * @param $post
     * @return array
     */
    public function getLikes($post)
    {
        $likes = [];

        foreach ($post->socials as $provider) {
            $providerName = $provider->getProviderName();

            switch ($providerName) {
                case 'facebook':
                    $likes[$providerName] = $this->getLikesFromFacebook($provider);
                    break;
                case 'twitter':
                    $likes[$providerName] = $this->getLikesFromTwitter($provider);
                    break;
                default:
                    break;
            }
        }

        return $likes;
    }

    /**
     * Get likes from facebook for a post.
     *
     * @param $provider
     * @return array
     */
    public function getLikesFromFacebook($provider)
    {
        $address = '/' . $provider->getSocialPostID() . '?fields=likes.summary(true)';
        $cSocial = null;

        foreach ($this->socials as $social) {
            if ($social->getProviderName() === 'facebook') {
                $cSocial = $social;
                break;
            }
        }

        try {
            $answer = $this->fb->get($address, $cSocial->getToken());
        } catch (FacebookSDKException $e) {
            return [
                'messages' => [ $e->getMessage() ],
                'status' => false
            ];
        }

        $answer = \GuzzleHttp\json_decode($answer->getBody());

        return [
            'count' => $answer->likes->summary->total_count,
            'status' => true
        ];
    }


    public function getLikesFromTwitter($provider)
    {
        $address = '/statuses/show/' . $provider->getSocialPostID();

        $cSocial = null;

        foreach ($this->socials as $social) {
            if ($social->getProviderName() === 'twitter') {
                $cSocial = $social;
                break;
            }
        }

        $this->twitter_connection->setOauthToken($cSocial->getToken(), $cSocial->getSecretToken());
        $response = $this->twitter_connection->get($address);

        if ($this->twitter_connection->getLastHttpCode() === 200) {
            return [
                'count' => $response->favorite_count,
                'status' => true
            ];
        }

        return [
            'messages' => $response->errors,
            'status' => false
        ];
    }
}