<?php

namespace App\Http\Controllers\Account;

use App\Http\Requests\StorePostRequest;
use App\Jobs\SendPlannedPost;
use App\Post;
use App\Services\PostService;
use App\SocialPost;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Send the post to socials.
     *
     * @param StorePostRequest $request
     * @param PostService $service
     * @return \Illuminate\Http\JsonResponse
     * @throws \InvalidArgumentException
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function store(StorePostRequest $request, PostService $service)
    {
        $providers = $request->input('socials');
        $post = new Post($request->only(['body']));
        $post->setPlanned($request->input('is_plan'));

        if($request->input('is_plan')) {
            return $this->planPost($post, $providers, $request->input('date'));
        } else {
            return $this->storePost($post, $service, $providers);
        }
    }

    /**
     * Store the post in DB.
     *
     * @param Post $post
     * @param PostService $service
     * @param $providers
     * @return \Illuminate\Http\JsonResponse
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function storePost(Post $post, PostService $service, $providers)
    {
        $user = \Auth::user();
        $response = $service->send($post, $providers, $user);

        $postSocialModels = [];

        /** @var array $providers */
        foreach($providers as $social) {
            $postSocialModels[] = new SocialPost([
                'post_provider_id' => $social['id'],
                'provider' => $social['provider'],
                'status' => $response['posts'][$social['provider']]['status']
            ]);
        }

        $status = 400;

        if($response['status']) {
            $user->posts()->save($post);
            $post->socials()->saveMany($postSocialModels);
            $status = 200;
        }

        return Response::json($response, $status);
    }

    /**
     * Plan new Post to post.
     *
     * @param Post $post
     * @param $providers
     * @param $date
     * @return \Illuminate\Http\JsonResponse
     * @throws \InvalidArgumentException
     */
    public function planPost(Post $post, $providers, $date)
    {
        $user = \Auth::user();
        $postSocialModels = [];

        /** @var array $providers */
        foreach($providers as $social) {
            $postSocialModels[] = new SocialPost([
                'post_provider_id' => $social['id'],
                'provider' => $social['provider'],
                'status' => 0
            ]);
        }

        $user->posts()->save($post);
        $post->socials()->saveMany($postSocialModels);

        $job = (new SendPlannedPost($user, $post, $providers))
            ->delay( Carbon::createFromFormat('Y-m-d H:i', $date ));

        dispatch($job);

        return Response::json([
            'status' => true,
            'code' => 200,
            'message' => 'Tweet will be posted at '.$date
        ]);
    }
}
