<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Authenticate user in system.
     *
     * @param Request $request
     * @return mixed|json
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return Response::json(['error' => 'User credentials are not correct!'], 401);
            }
        } catch (JWTException $e) {
            return Response::json(['error' => 'Something went wrong!'], 500);
        }

        return Response::json(compact('token'));
    }
}
