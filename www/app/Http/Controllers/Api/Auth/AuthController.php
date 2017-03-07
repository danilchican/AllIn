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
        $this->middleware('guest', ['only' => 'login']);
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

    /**
     * Get user info.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthUser() {
        try {
            if (! $user = JWTAuth::parseToken()->toUser()) {
                return Response::json(['error' => 'User not found!'], 404);
            }
        } catch (JWTException $e) {
            return Response::json(['error' => 'Something went wrong!'], 500);
        }

        return Response::json(compact('user'));
    }

    /**
     * Logout user from system.
     *
     * @return mixed|json
     */
    public function logout() {
        $token = JWTAuth::getToken();

        try {
            if (! JWTAuth::invalidate($token)) {
                return Response::json(['error' => 'Can\'t logout from server!'], 401);
            }
        } catch (JWTException $e) {
            return Response::json(['error' => 'Something went wrong!'], 500);
        }

        return Response::json([
            'success' => 'User is logged off.'
        ]);
    }
}
