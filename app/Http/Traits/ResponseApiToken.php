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
        $id_owner = Auth::user()->id_owner;
        $type = Auth::user()->type;
        $id_kios = DB::table('operator_kios')->select('kios_id')->where('admin_id', $id_owner)->get();

        if ($type == 'admin')
        {
            $user = DB::table('kios')->where('id_owner', $id_owner)->first();
        }
        else
        {
            $user = DB::table('kios')->where('id', $id_kios)->first();
        }
        
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
