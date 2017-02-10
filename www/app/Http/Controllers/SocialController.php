<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Services\SocialAccountService;

class SocialController extends Controller
{

    /**
     * Login.
     *
     * @param $provider
     * @return mixed
     */
    public function login($provider)
    {
        $scopes = [];

        if(!strcmp($provider, 'vkontakte')) {
            $scopes = ['photos', 'wall', 'offline', 'groups', 'stats', 'docs'];
        }

        return Socialite::with($provider)->scopes($scopes)->redirect();
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

        $user = $service->createOrGetUser($driver, $provider);

        \Auth::login($user, true);

        return redirect()->intended('/home');
    }

}