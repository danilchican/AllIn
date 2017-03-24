<?php

namespace App\Http\Controllers;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Services\SocialAccountService;

class SocialController extends Controller
{
    private $scopes = [];

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['create', 'appendSocialCallback']]);
    }

    /**
     * Login.
     *
     * @param $provider
     * @return mixed
     */
    public function login($provider)
    {
        if (!strcmp($provider, 'vkontakte')) {
            $this->scopes = ['photos', 'wall', 'offline', 'groups', 'stats', 'docs'];
        } else if (!strcmp($provider, 'facebook')) {
            $this->scopes = ['publish_actions', 'manage_pages', 'publish_pages'];
        } else if (!strcmp($provider, 'twitter')) {
            return Socialite::with($provider)->redirect();
        }

        return Socialite::with($provider)->scopes($this->scopes)->redirect();
    }

    /**
     * Callback function.
     *
     * @param SocialAccountService $service
     * @param $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback(SocialAccountService $service, $provider)
    {
        $driver = Socialite::driver($provider);
        $response = $service->createOrGetUser($driver, $provider);
        $user = $response['user'];

        \Auth::login($user, true);

        if ($response['isNewUser'] === true) {
            return redirect('/home/settings')->with([
                'message' => 'Ваш пароль: \'secret\'. Пожалуйста, измените данный пароль для надежности.'
            ]);
        }

        return redirect('/home');
    }

    /**
     * Append social to user account.
     *
     * @param $provider
     * @param SocialAccountService $service
     * @param Request $request
     * @return mixed
     * @throws \RuntimeException
     * @throws \Abraham\TwitterOAuth\TwitterOAuthException
     */
    public function create($provider, SocialAccountService $service, Request $request)
    {
        if (!strcmp($provider, 'vkontakte')) {
            $this->scopes = ['photos', 'wall', 'offline', 'groups', 'stats', 'docs'];
        } else if (!strcmp($provider, 'facebook')) {
            $this->scopes = ['publish_actions', 'manage_pages', 'publish_pages'];
        } else if (!strcmp($provider, 'twitter')) {
            return $service->twitterDriver($request)->redirect();
        }

        return Socialite::with($provider)
            ->scopes($this->scopes)
            ->redirectUrl(env('APP_URL') . '/socials/' . $provider . '/callback')
            ->redirect();
    }

    /**
     * Append social to user callback.
     *
     * @param SocialAccountService $service
     * @param $provider
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \RuntimeException
     */
    public function appendSocialCallback(SocialAccountService $service, Request $request, $provider)
    {
        if (!strcmp($provider, 'twitter')) {
            $response = $service->appendTwitter($request);
        } else {
            $driver = Socialite::driver($provider)
                ->redirectUrl(env('APP_URL') . '/socials/' . $provider . '/callback');

            $response = $service->appendSocialAccount($driver, $provider);
        }

        if ($response['existAccount'] === true) {
            return redirect('/home/accounts')->with([
                'message' => 'Данная соц.сеть уже подключена.'
            ]);
        }

        return redirect('/home/accounts');
    }
}