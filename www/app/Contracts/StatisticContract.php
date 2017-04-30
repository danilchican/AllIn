<?php

namespace App\Contracts;

interface StatisticContract
{
    public function getLikesForPosts($posts, $user);

    public function getLikes($providers);
    public function getLikesFromFacebook($provider);
    public function getLikesFromTwitter($provider);
}