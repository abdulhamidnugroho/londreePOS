<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseApiToken;
use App\User;
use Illuminate\Auth\Authenticatable;
use JWTAuth;

class LoginController extends Controller
{
    use ResponseApiToken;

    /**
     * Get a JWT via given credentials.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'User not found'
            ], 401);
        }
        
        // Use this, if there is MD5 password used
        $user = User::where([ 
            'email' => $request->email,
            'password' => md5($request->password)
        ])->first();

        if ($user) {
            $this->guard()->login($user);

            return redirect('other/path');;
        }

        return redirect('fail-path-with-instructions-for-create-account');

        return $this->respondWithToken($token);
    }
}
