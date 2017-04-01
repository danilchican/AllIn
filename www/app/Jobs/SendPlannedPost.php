<?php

namespace App\Jobs;

use App\Post;
use App\Services\PostService;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendPlannedPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    private $user;
    private $post;

    private $providers;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param Post $post
     * @param $providers
     */
    public function __construct(User $user, Post $post, $providers)
    {
        $this->user = $user;
        $this->post = $post;
        $this->providers = $providers;
    }

    /**
     * Execute the job.
     *
     * @param PostService $service
     * @return void
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function handle(PostService $service)
    {
        $response = $service->send($this->post, $this->providers, $this->user);

        if($response['status']) {
            $this->post->socials()->update(['status' => true]);
        }
    }
}
