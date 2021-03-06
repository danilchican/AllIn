<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Response;

class SocialController extends Controller
{
    /**
     * Get associated socials account for authorized user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAssociatedAccounts() {

        try {
            if (! $user = JWTAuth::parseToken()->toUser()) {
                return Response::json(['error' => 'User not found!', 'code' => 404], 404);
            }

            $socials = $user->socials()->get();

            if($socials->isEmpty()) {
                return Response::json([
                    'message' => 'User haven\'t any socials accounts!',
                    'code' => 200
                ]);
            }
        } catch (JWTException $e) {
            return Response::json(['error' => 'Something went wrong!', 'code' => 500], 500);
        }

        return Response::json(['socials' => $socials, 'code' => 200]);
    }
}
