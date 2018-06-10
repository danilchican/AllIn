<?php

namespace App\Services;

use App\Contracts\SocialContract;
use App\Contracts\StatisticContract;
use App\Helpers\SocialRequest;
use Carbon\Carbon;
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
     *
     * @return array
     */
    public function getLikesForPosts($posts, $user)
    {
        $this->user = $user;
        $this->socials = $user->socials;

        $response = [];

        $fromDate = Carbon::tomorrow()->subWeek();
        $toDate = Carbon::now();

        for (; $fromDate->lt($toDate); $fromDate = $fromDate->addDay()) {
            $response['likes'][$fromDate->format('Y-m-d')] = [
                'twitter'  => 0,
                'facebook' => 0,
            ];
            $response['labels'][] = $fromDate->format('Y-m-d');
        }

        $lastDate = null;

        /** @var array $posts */
        foreach ($posts as $post) {
            $temp = [
                'likes' => $this->getLikes($post),
                'post'  => $post,
            ];

            $curDate = $post->updated_at->hour(0)->minute(0)->second(0);

            if (null === $lastDate) {
                $lastDate = $curDate;
            } else if ($lastDate->lt($curDate)) {
                $lastDate = $curDate;
            }

            $Mkey = $lastDate->format('Y-m-d');

            if (!array_key_exists($Mkey, $response['likes'])) {
                $response['likes'][$Mkey] = $temp['likes'];
            } else {
                $oldLikes = $response['likes'][$Mkey];
                $newLikes = $temp['likes'];

                foreach ($oldLikes as $key => $like) {
                    if (!array_key_exists($key, $newLikes)) {
                        $newLikes[$key] = $like;
                    } else {
                        $m = $newLikes[$key];
                        $newLikes[$key] = $m + $like;
                    }
                }

                $response['likes'][$Mkey] = $newLikes;
            }
        }

        return $response;
    }

    /**
     * Get likes for current post.
     *
     * @param $post
     *
     * @return array
     */
    public function getLikes($post)
    {
        $likes = [];
        $response = null;

        foreach ($post->socials as $provider) {
            $providerName = $provider->getProviderName();

            switch ($providerName) {
                case 'facebook':
                    $response = $this->getLikesFromFacebook($provider);
                    if ($response['status'] !== false) {
                        $likes[$providerName] = $response['count'];
                    }
                    break;
                case 'twitter':
                    $response = $this->getLikesFromTwitter($provider);
                    if ($response['status'] !== false) {
                        $likes[$providerName] = $response['count'];
                    }
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
     *
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
                'messages' => [$e->getMessage()],
                'status'   => false,
            ];
        }

        $answer = \GuzzleHttp\json_decode($answer->getBody());

        return [
            'count'  => $answer->likes->summary->total_count,
            'status' => true,
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
                'count'  => $response->favorite_count,
                'status' => true,
            ];
        }

        return [
            'messages' => $response->errors,
            'status'   => false,
        ];
    }
}