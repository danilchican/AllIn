<?php

namespace App\Services;

use App\Contracts\SocialContract;
use App\Contracts\StatisticContract;
use App\Helpers\SocialRequest;

class StatisticService implements SocialContract, StatisticContract
{
    use SocialRequest;

    /**
     * Get the likes for each post.
     *
     * @param $posts
     */
    public function getLikesForPosts($posts) {
        $response = [];


    }
}