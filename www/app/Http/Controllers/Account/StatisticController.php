<?php

namespace App\Http\Controllers\Account;

use App\Services\StatisticService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;

class StatisticController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get statistic by week.
     *
     * @param StatisticService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexLikes(StatisticService $service)
    {
        $user = \Auth::user();

        $fromDate = Carbon::today()->subWeek();
        $toDate = Carbon::tomorrow()->subSecond();

        $posts = $user->posts()
            ->where('updated_at', '>=', $fromDate)
            ->where('updated_at', '<=', $toDate)
            ->with('socials')
            ->get();

        $response = $service->getLikesForPosts($posts, $user);

        return Response::json($response);
    }
}