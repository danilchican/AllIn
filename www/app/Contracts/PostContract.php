<?php

namespace App\Contracts;

use App\Post;

interface PostContract
{
    public function send(Post $post, $providerName, $providerUser);

    public function sendVkontaktePost(Post $post, $providerUser);
    public function sendFacebookPost(Post $post, $providerUser);
}