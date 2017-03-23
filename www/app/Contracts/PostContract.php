<?php

namespace App\Contracts;

use App\Post;

interface PostContract
{
    public function send(Post $post, $providerName, $user);

    public function sendVkontaktePost(Post $post, $user, $provider);
    public function sendFacebookPost(Post $post, $user, $provider);
}