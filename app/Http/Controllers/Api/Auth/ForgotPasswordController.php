<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Traits\PasswordRandom;
use App\Notifications\UserForgotPassword;
use App\User;
use Notification;

class ForgotPasswordController extends Controller
{
    use PasswordRandom;

    /**
     * Forgot password.
     *
     * @param ForgotPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ForgotPasswordRequest $request)
    {
        $passwordRandom = $this->getRandomPassword();
        $user = User::where('email', '=', $request->get('email'))->first();
        $user->password = bcrypt($passwordRandom);
        $user->save();

        Notification::send($user, new UserForgotPassword($user, $passwordRandom));

        if (!$user) {
            return response()->json([
                'message' => 'We can\'t find a user with that e-mail address.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully change password'
        ], 200);
    }
}
