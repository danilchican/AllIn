<?php

namespace App\Http\Controllers\Account;

use App\Http\Requests\StorePostRequest;
use App\Post;
use App\Services\PostService;
use App\SocialPost;
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

    public function store(StorePostRequest $request, PostService $service)
    {
        $user = \Auth::user();

        $providers = $request->input('socials');
        $postSocialModels = [];

        $post = new Post($request->only(['body', 'is_plan']));

        /** @var array $providers */
        foreach($providers as $social) {
            $postSocialModels[] = new SocialPost([
                'post_provider_id' => $social['id'],
                'provider' => $social['provider']
            ]);
        }

        $response = $service->send($post, $providers, $user);

        $status = 400;

        if($response['status']) {
            $user->posts()->save($post);
            $post->socials()->saveMany($postSocialModels);
            $status = 200;
        }

        return Response::json($response, $status);
    }
}
