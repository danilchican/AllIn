<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StatisticService;
use Carbon\Carbon;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Response;

class StatisticController extends Controller
{
    /**
     * Get like statistic by week.
     *
     * @param StatisticService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexLikes(StatisticService $service) {

        try {
            if (! $user = JWTAuth::parseToken()->toUser()) {
                return Response::json(['error' => 'User not found!', 'code' => 404], 404);
            }

            $fromDate = Carbon::today()->subWeek();
            $toDate = Carbon::tomorrow()->subSecond();

            $posts = $user->posts()
                ->where('updated_at', '>=', $fromDate)
                ->where('updated_at', '<=', $toDate)
                ->with('socials')->orderBy('updated_at', 'asc')
                ->get();

            $response = $service->getLikesForPosts($posts, $user);

            return Response::json($response);
        } catch (JWTException $e) {
            return Response::json(['error' => 'Something went wrong!', 'code' => 500], 500);
        }
    }
}