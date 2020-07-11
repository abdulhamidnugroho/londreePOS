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
        $id = Auth::user()->id;
        $id_owner = Auth::user()->id_owner;
        $type = Auth::user()->type;
        $id_kios = DB::table('operator_kios')->where('admin_id', $id_owner)->value('kios_id');
        $data_user = DB::table('admin')->where('id', $id )->first();
        
        if ($type == 'admin')
        {
            $kios = DB::table('kios')->where('id_owner', $id_owner)->first();
        }
        else
        {
            $kios = DB::table('kios')->where('id', $id_kios)->first();
        }
        
        $data = [
            'id_owner' => $id_owner,
            'type' => $type,
            'id_kios' => $id_kios,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'kios' => $kios,
            'jml_transaksi' => $data_user->jml_transaksi,
            'paket_akun_id' => $data_user->paket_akun_id,
            'pesan_antar' => $data_user->pesan_antar,
        ];
        
        return response()->json([
            'status' => true,
            'pesan' => 'success',
            'data' => $data
        ]);
    }
}
