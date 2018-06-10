<?php

namespace App\Http\Controllers\Account;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class AccountController extends Controller
{
    /**
     * The hasher implementation.
     *
     * @var \Illuminate\Contracts\Hashing\Hasher
     */
    protected $hasher;

    /**
     * Create a new controller instance.
     *
     * @param HasherContract $hasher
     */
    public function __construct(HasherContract $hasher)
    {
        $this->hasher = $hasher;
        $this->middleware('auth');
    }

    /**
     * Return account index page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = \Auth::user();

        return view('account.index')
            ->with(compact('user'));
    }

    /**
     * Get user info.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserInfo()
    {
        return Response::json(['user' => \Auth::user(), 'code' => 200], 200);
    }

    /**
     * Get user's socials.
     *
     * @return mixed|json
     */
    public function getAttachedSocials()
    {
        if (!$user = \Auth::user()) {
            return Response::json(['error' => 'User not found!', 'code' => 404], 404);
        }

        $socials = $user->socials()->get();

        if ($socials->isEmpty()) {
            return Response::json([
                'message' => 'User haven\'t any socials accounts!',
                'code'    => 200,
            ]);
        }

        return Response::json(['socials' => $socials, 'code' => 200]);
    }

    /**
     * Change user's password.
     *
     * @param ChangePasswordRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = \Auth::user();

        if ($this->hasher->check($request->input('currentPassword'), $user->password)) {
            $user->setPassword($request->input('newPassword'));

            if ($user->save()) {
                return Response::json([
                    'message' => 'Password changed successfully.',
                    'success'  => true,
                ]);
            }
        }

        return Response::json([
            'message' => 'Can\'t change password. Maybe you are trying to enter invalid current password.',
            'success'  => false,
        ]);
    }
}
