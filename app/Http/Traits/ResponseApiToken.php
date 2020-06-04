<?php

namespace App\Http\Traits;

use DB;
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
        $id_kios = DB::table('operator_kios')->where('admin_id', $id_owner)->value('kios_id');
        // $user = [];
        
        if ($type == 'admin')
        {
            $user = DB::table('kios')->where('id_owner', $id_owner)->first();
            // $orders = DB::table('orders')
            //     ->whereRaw('price > IF(state = "TX", ?, 100)', [200])
            //     ->get();
        }
        else
        {
            $user = DB::table('kios')->where('id', $id_kios)->first();
        }
        
        return response()->json([
            'status' => true,
            'pesan' => 'success',
            'data' => [
                'id_owner' => $id_owner,
                'type' => $type,
                'id_kios' => $id_kios,
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'kios' => $user,
            ]
        ]);
    }
}
