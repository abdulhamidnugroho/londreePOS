<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Register\TambahKiosRequest;
use App\Http\Requests\Register\TambahOperatorRequest;
use App\Kios;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Create User
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $user = User::insert([
                'nama' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'type' => $request->type,
                'trash' => $request->trash,
                'id_owner' => 1086,
                'active_until' => $request->active_until,
                'activation_code' => rand(100000, 999999),
                'fcm_token' => Str::random(152),
                'reveral' => Str::random(6),
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => "Failed to register user, please try again. {$exception->getMessage()}"
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    /**
     * Create New Owner
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function tambahowner(RegisterRequest $request)
    {   
        try {
            $owner = User::insert([
                'type' => 'owner',
                'nama' => $request->nama, 
                'email' => $request->email,
                'alamat' => $request->alamat,
                'telp' => $request->no_telp,
                'id_owner' => 1086,
                'password' => bcrypt($request->password),
                'last_update' => date("Y-m-d H:i:s"),
                'active_until' => NULL,
                'activation_code' => rand(100000, 999999),
                'reveral' => Str::random(6)
                ]);
                
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => "Failed to register user, please try again. {$exception->getMessage()}"
            ], 500);
        }

        return response([
            'status' => 'sukses menambah owner',
            'data' => $owner
        ], 200);
    }

    /**
     * Create New Kios
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function tambahkios(TambahKiosRequest $request)
    {   
        
        try {
            $kios = Kios::insert([
                'nama' => $request->nama, 
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
                'latitude' => $request->latitude,
                'id_owner' => 1086,
                'pesan_antar' => $request->pesan_antar,
                'ketentuan' => $request->ketentuan,
                'estimasi' => $request->estimasi,
                'pesan_wa_sms' => '',
                ]);
                
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => "Failed to register kios, please try again. {$exception->getMessage()}"
            ], 500);
        }

        return response([
            'status' => 'success',
            'data' => $kios
        ], 200);
    }

    /**
     * Create New Operator
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function tambahoperatorkios(TambahOperatorRequest $request)
    {   
        try {
            $kios = User::insert([
                'type' => 'operator',
                'nama' => $request->nama, 
                'alamat' => $request->alamat,
                'email' => $request->email,
                'telp' => $request->telp,
                'password' => $request->password,
                'last_update' => $request->last_update,
                'active_until' => NULL,
                'id_owner' => $request->id_owner,
                'activation_code' => rand(100000, 999999),
                'reveral' => Str::random(6)
            ]);
                
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => "Failed to register kios, please try again. {$exception->getMessage()}"
            ], 500);
        }

        return response([
            'status' => 'sukses menambah operator',
            'data' => $kios
        ], 200);
    }
}
