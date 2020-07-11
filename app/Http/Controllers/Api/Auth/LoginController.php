<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseApiToken;
use App\User;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use DB;

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
        // Cek jika password masih pakai hash md5 
        $user = User::where('email', '=', $request->email)->first();

        if (md5(md5($request->password)) == $user->password)
        {
            // Update password ke bcrypt
            $passwordUpdate = DB::table('admin')
            ->where('email', '=', $request->email)
            ->update(['password' => bcrypt($request->password)]);

            if ($passwordUpdate)
            {
                $credentials = $request->only("email", "password");

                if (!$token = JWTAuth::attempt($credentials)) {
                    return response()->json([
                        'error' => 'Unauthorized',
                        'message' => 'User not found'
                    ], 401);
                }

                return $this->respondWithToken($token);
            } else {
                return "Update password error";
            }
        } else {
            $credentials = $request->only("email", "password");

            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => 'Unauthorized',
                    'message' => 'User not found'
                ], 401);
            }
            return $this->respondWithToken($token);
        }
    }
}
