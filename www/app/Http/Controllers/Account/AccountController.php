<?php

namespace App\Http\Controllers\Account;

use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Return account index page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('account.index');
    }

    /**
     * Get user's socials.
     *
     * @return mixed|json
     */
    public function getAttachedSocials()
    {
        if (! $user = \Auth::user()) {
            return Response::json(['error' => 'User not found!', 'code' => 404], 404);
        }

        $socials = $user->socials()->get();

        if($socials->isEmpty()) {
            return Response::json([
                'message' => 'User haven\'t any socials accounts!',
                'code' => 200
            ]);
        }

        return Response::json(['socials' => $socials, 'code' => 200]);
    }
}
