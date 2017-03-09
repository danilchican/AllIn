<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Services\SocialAccountService;

class SocialController extends Controller
{
    private $scopes = [];

//    /**
//     * Create a new controller instance.
//     *
//     */
//    public function __construct()
//    {
//        $this->middleware('guest', ['except' => ['create', 'appendSocialCallback']]);
//    }

    /**
     * Login.
     *
     * @param $provider
     * @return mixed
     */
    public function login($provider)
    {
        if(!strcmp($provider, 'vkontakte')) {
            $this->scopes = ['photos', 'wall', 'offline', 'groups', 'stats', 'docs'];
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

        if($response['isNewUser'] === true) {
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
     * @return mixed
     */
    public function create($provider) {
        if(!strcmp($provider, 'vkontakte')) {
            $this->scopes = ['photos', 'wall', 'offline', 'groups', 'stats', 'docs'];
        }

        return Socialite::with($provider)
            ->scopes($this->scopes)
            ->redirectUrl(env('APP_URL').'/socials/'.$provider.'/callback')
            ->redirect();
    }

    /**
     * Append social to user callback.
     *
     * @param SocialAccountService $service
     * @param $provider
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function appendSocialCallback(SocialAccountService $service, $provider)
    {
        $driver = Socialite::driver($provider)->redirectUrl(env('APP_URL').'/socials/'.$provider.'/callback');

        $response = $service->appendSocialAccount($driver, $provider);

        if($response['existAccount'] === true) {
            return redirect('/home/accounts')->with([
                'message' => 'Данная соц.сеть уже подключена.'
            ]);
        }

        return redirect('/home/accounts');
    }
}