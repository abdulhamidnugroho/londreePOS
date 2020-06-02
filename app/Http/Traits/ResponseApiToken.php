<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;

trait ResponseApiToken
{
    /**
    * Get the token array structure.
    *
    * @param  string $token
    * @return \Illuminate\Http\JsonResponse
    */
    protected function respondWithToken($token)
    {
        $id = Auth::user()->id;
        return response()->json([
            'status' => true,
            'pesan' => 'success',
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        ]);
    }
}
