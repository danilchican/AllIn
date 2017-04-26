<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Jobs\SendPlannedPost;
use App\Post;
use App\Services\PostService;
use App\SocialPost;
use Carbon\Carbon;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Response;

class PostController extends Controller
{
    /**
     * Publish new post.
     *
     * @param StorePostRequest $request
     * @param PostService $service
     * @return \Illuminate\Http\JsonResponse
     * @throws \InvalidArgumentException
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function store(StorePostRequest $request, PostService $service) {
        try {
            if (! $user = JWTAuth::parseToken()->toUser()) {
                return Response::json(['error' => 'User not found!', 'code' => 404], 404);
            }

            $providers = $request->input('socials');
            $post = new Post($request->only(['body']));
            $post->setPlanned($request->input('is_plan'));

            if($request->input('is_plan')) {
                return $this->planPost($user, $post, $providers, $request->input('date'));
            } else {
                return $this->storePost($user, $post, $service, $providers);
            }

        } catch (JWTException $e) {
            return Response::json(['error' => 'Something went wrong!', 'code' => 500], 500);
        }
    }

    /**
     * Store new post & publish it.
     *
     * @param $user
     * @param Post $post
     * @param PostService $service
     * @param $providers
     * @return \Illuminate\Http\JsonResponse
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function storePost($user, Post $post, PostService $service, $providers)
    {
        $response = $service->send($post, $providers, $user);

        $postSocialModels = [];

        /** @var array $providers */
        foreach($providers as $social) {
            $postSocialModels[] = new SocialPost([
                'provider_id' => $social['id'],
                'social_post_id' => $response['posts'][$social['provider']]['id'],
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
     * Plan new post.
     *
     * @param $user
     * @param Post $post
     * @param $providers
     * @param $date
     * @return \Illuminate\Http\JsonResponse
     * @throws \InvalidArgumentException
     */
    public function planPost($user, Post $post, $providers, $date)
    {
        $postSocialModels = [];

        /** @var array $providers */
        foreach($providers as $social) {
            $postSocialModels[] = new SocialPost([
                'provider_id' => $social['id'],
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